<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\TravelTypeRepository;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class NewAdminUserSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an Admin User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TravelTypeRepository $travelTypeRepository)
    {
        $availableTravelTypes = $travelTypeRepository->all()->pluck("name")->toArray();

        // Input Gathering
        $firstName = $this->ask("Kindly provide your First Name", "Opeyemi");
        $lastName = $this->ask("Kindly provide your Last Name", "Matti");

        $email = $this->withValidation(function () {
            return $this->ask("Kindly provide your email address");
        }, "required|email", [
            "required" => "Email Address is required",
            "email" => "You need to provide a valid email"
        ]);

        $password = $this->withValidation(function () {
            return $this->secret("What is your password?");
        }, "required|min:8", [
            "required" => "Password is required",
            "min" => "Cannot be less than 8 characters"
        ]);

        $travelType = $this->withValidation(function () use ($availableTravelTypes) {
            return $this->choice("Select your preferred travel type", $availableTravelTypes);
        }, "required|in:" . implode(",", $availableTravelTypes), [
            "required" => "You have to select your preferred travel type",
            "in" => "Travel type must be one of: " .  implode(", ", $availableTravelTypes)
        ]);

        $distance = $this->getValidDistance($travelTypeRepository, $travelType);

        User::query()->create([
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            'email_verified_at' => now(),
            "password" => Hash::make($password),
            "travel_type_id" => $travelTypeRepository->findByName($travelType)["id"],
            "distance_from_home" => $distance,
            "is_admin" => true
        ]);

        $this->info("Admin User Created Successfully. Kindly proceed to the login using the provided credentials");
    }

    private function getValidDistance(TravelTypeRepository $travelTypeRepository, $travelTypeName)
    {
        if (empty($travelTypeName)) {
            throw new InvalidArgumentException("traveltypeName cannot be empty");
        }

        $travelType = $travelTypeRepository->findByName($travelTypeName);

        $distance = $this->withValidation(function () {
            return $this->ask("What is the distance in kilometers between your home and the office?");
        }, [
            "required", "numeric", "min:0.1",
            function ($attribute, $value, $fail) use ($travelType) {
                $maxDistanceFromHome = collect($travelType["exceptions"])->min("min_km") ?? INF;

                if ($value > $maxDistanceFromHome) {
                    return $fail("Distance provided for the selected travel type cannot be greater than {$maxDistanceFromHome}km");
                }
            }
        ], [
            "required" => "Distance is required",
            "numeric" => "Distance must be numeric",
            "min" => "Distance cannot be less than 0.1km (100 meters)"
        ]);

        return $distance;
    }

    protected function withValidation(Closure $callback, $rules, array $messages = [])
    {
        $input = $callback();

        $mapMessages = static function ($message, $rule) {
            return ["input.$rule" => $message];
        };

        $validator = Validator::make(
            compact('input'),
            ['input' => $rules],
            collect($messages)->mapWithKeys($mapMessages)->toArray()
        );

        if ($validator->fails()) {
            $this->warn($validator->errors()->first());
            $input = $this->withValidation($callback, $rules, $messages);
        }

        return is_string($input) && $input === '' ? null : $input;
    }
}

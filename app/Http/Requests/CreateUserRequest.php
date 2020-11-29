<?php

namespace App\Http\Requests;

use App\Repositories\TravelTypeRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var TravelTypeRepository */
        $travelTypeRepo = app(TravelTypeRepository::class);

        $travelTypeIds = $travelTypeRepo->all()->pluck('id')->toArray();

        $this->request->set("is_admin", $this->filled("is_admin"));

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'travel_type_id' => ["required", Rule::in($travelTypeIds)],
            "distance_from_home" => [
                "required", "numeric",
                function ($attribute, $value, $fail) use ($travelTypeRepo) {
                    $travelType = $travelTypeRepo->findById($this->request->get("travel_type_id"));
                    $maxDistanceFromHome = collect($travelType["exceptions"])->min("min_km") ?? INF;

                    if ($value > $maxDistanceFromHome) {
                        return $fail("{$attribute} for the selected travel type cannot be greater than {$maxDistanceFromHome}km");
                    }
                }
            ]
        ];
    }
}

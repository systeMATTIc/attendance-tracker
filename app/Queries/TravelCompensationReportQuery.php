<?php

namespace App\Queries;

use App\Models\User;
use App\Repositories\TravelTypeRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon;

class TravelCompensationReportQuery
{
    private $travelTypeRepository;

    public function __construct(TravelTypeRepository $travelTypeRepository)
    {
        $this->travelTypeRepository = $travelTypeRepository;
    }

    public function __invoke($year, $month)
    {
        $attendances = User::all()->map(function (User $user) use ($year, $month) {
            $attendances = $user->attendances()->getBaseQuery()
                ->whereYear("time_in", $year)
                ->whereMonth("time_in", $month)
                ->get();

            $travelType = $this->travelTypeRepository->findById($user->travel_type_id);

            $roundTripDistance = (float) $user->distance_from_home * 2;

            $totalTravelledDistance = $roundTripDistance * $attendances->count();

            $compensation = $this->calculateCompensationAmount(
                $totalTravelledDistance,
                $roundTripDistance,
                $travelType['base_compensation_per_km'],
                $travelType["exceptions"]
            );

            $dateInstance = CarbonImmutable::parse("$year-$month");

            $paymentDate = $dateInstance->addMonth()->startOfWeek(Carbon::MONDAY)->isSameMonth($dateInstance)
                ? $dateInstance->addMonth()->addWeek()->startOfWeek(Carbon::MONDAY)->format("Y-m-d")
                : $dateInstance->addMonth()->startOfWeek(Carbon::MONDAY)->format("Y-m-d");

            return [
                "Employee" => $user->name,
                "Transport" => $travelType["name"],
                "Travelled Distance" => $totalTravelledDistance,
                "Compensation" => $compensation,
                "Payment Date" => $paymentDate
            ];
        });

        return $attendances;
    }

    private function calculateCompensationAmount($totalTravelledDistance, $roundTripDistance, $baseCompensationRate, $exceptions = [])
    {
        if (empty($exceptions)) {
            $compensation = $totalTravelledDistance * (float) $baseCompensationRate;
        } else {
            $exception = collect($exceptions)->first(
                function ($exception) use ($roundTripDistance) {
                    return $roundTripDistance >= (float) $exception["min_km"]
                        && $roundTripDistance <= (float) $exception["max_km"];
                }
            );

            $factor = is_null($exception) ? 1 : @$exception["factor"];

            $compensation = (float) $factor * $totalTravelledDistance * (float) $baseCompensationRate;
        }

        return $compensation;
    }
}

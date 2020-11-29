<?php

namespace App\Clients;

use App\Models\TravelType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TravelTypesClient
{
    protected $travelTypes;

    public function __construct()
    {
        $this->travelTypes = Cache::remember("travel_types", 3600, function () {
            $this->refresh();
            return $this->travelTypes;
        });
    }

    public function refresh()
    {

        $response = Http::get("https://api.staging.yeshugo.com/applicant/travel_types");

        if ($response->failed()) {
            throw new \Exception("Error retrieving available travel types");
        }

        $this->travelTypes = $response->json();

        return $this;
    }

    public function getTravelTypes()
    {
        return $this->travelTypes;
    }
}

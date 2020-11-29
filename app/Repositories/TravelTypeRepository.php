<?php

namespace App\Repositories;

use App\Clients\TravelTypesClient;
use App\Models\TravelType;
use Exception;

class TravelTypeRepository
{
    protected $client;

    public function __construct(TravelTypesClient $client)
    {
        $this->client = $client;
    }

    public function all()
    {
        return collect($this->client->getTravelTypes())->map(function ($type) {
            return new TravelType($type);
        });
    }

    public function findById($id)
    {
        $travelType = collect($this->client->getTravelTypes())->first(function ($type) use ($id) {
            return $type['id'] == $id;
        });

        if (is_null($travelType)) {
            throw new Exception("Travel type not found");
        }

        return new TravelType($travelType);
    }

    public function findByName($name)
    {
        $travelType = collect($this->client->getTravelTypes())->first(function ($type) use ($name) {
            return $type['name'] == $name;
        });

        if (is_null($travelType)) {
            throw new Exception("Travel type not found");
        }

        return new TravelType($travelType);
    }
}

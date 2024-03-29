<?php

namespace App\Repository;

use App\Contracts\FlightRepositoryInterface;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FlightRepository implements FlightRepositoryInterface
{
    /**
     * Get all element of flight model.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Flight::all();
    }

    /**
     * Get one element of flight model by id.
     *
     * @param $id
     * @return Model
     */
    public function findById($id): Model
    {
        return Flight::where('id', $id)->get()->first();
    }

    /**
     * Create a new flight model element.
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        return Flight::create([
            'departure_place' => $data['departurePlace'],
            'arriving_place' => $data['arrivingPlace'],
            'flight_number' => 'LA'. rand(1000,1999),
            'carrier_name' => $data['carrierName'],
            'airplane_type' => $data['airplaneType'],
            'departure_date' => $data['departureDate'],
            'direction' => $data['direction'],
            'departure_time' => $data['departureTime'],
            'arriving_time' => $data['arrivingTime'],
            'free_seats' => rand(1,22)
        ]);
    }

    /**
     * Update one specify element of flight model.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data = []): Model
    {
        $flight = Flight::where('id', $id)->get()->first();

        return $flight->update([
                'departure_place' => $data['departurePlace'] ?? '*',
                'arriving_place' => $data['arrivingPlace'] ?? '*',
                'departure_date' => $data['departureDate'] ?? '2023-01-02',
                'arriving_time' => date("H:i",
                    strtotime($flight['departure_time'].'+'.explode(':',
                            $data['arrivingTime'] ?? '00:00')[0].' hour'.explode(':',
                            $data['arrivingTime'] ?? '00:00')[1].' minutes'
                    )
                ),
                'free_seats' => rand(1,11)
            ]);
    }

    /**
     * Remove one specify element of flight model.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $flight = Flight::where('id', $id)->get()->first();

        $flight->delete();
    }
}

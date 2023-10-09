<?php

namespace App\Repository;

use App\Contracts\CrudInterface;
use App\Models\FlightDetails;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FlightDetailsRepository implements CrudInterface
{
    /**
     * Get all element of flight details model.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return FlightDetails::all();
    }

    /**
     * Get one element of flight details model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return FlightDetails::where('id', $id)->get()->first();
    }

    /**
     * Create a new flight details model element.
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        return FlightDetails::create([
            'flight_number' => $data['flightNumber'],
            'airline' => $data['airline'],
            'airplane_type' => $data['airplaneType'],
            'cabin_class' => $data['cabinClass'],
            'source_airport' => $data['sourceAirport'],
            'destination_airport' => $data['destinationAirport'],
            'departure_date' => $data['departureDate'],
            'departure_time' => $data['departureTime'],
            'return_date' => $data['returnDate'] ?? null
        ]);
    }

    /**
     * Update one specify element of flight details model.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $flightDetails = FlightDetails::where('id', $id)->get()->first();

        return $flightDetails->update([
            'flight_number' => $data['flightNumber'],
            'airline' => $data['airline'],
            'airplane_type' => $data['airplaneType'],
            'cabin_class' => $data['cabinClass'],
            'source_airport' => $data['sourceAirport'],
            'destination_airport' => $data['destinationAirport'],
            'departure_date' => $data['departureDate'],
            'departure_time' => $data['departureTime'],
            'return_date' => $data['returnDate'] ?? null
        ]);
    }

    /**
     * Remove one specify element of flight details model.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $flightDetails = FlightDetails::where('id', $id)->get()->first();

        $flightDetails->delete();
    }
}

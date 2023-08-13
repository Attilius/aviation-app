<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationCost;
use App\Models\ReservationUtils;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    /**
     * Baggage adding and insurance page rendering.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $reservation = Reservation::find($request->session()->getId());
        $baggages = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['checked_baggage_items'];
        $reservationUtilsPax = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['pax'];
        $targetUrlOfPlaneChoosing = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['target_of_plane_choosing'];
        $passengersId = $reservation->passengers->pluck('id');
        $totalCost = ReservationCost::where('reservation_id', $request->session()->getId())->sum('price');
        $flightDetailsId = $reservation->flight_details_id;
        $airplaneType = FlightDetails::where('id', $flightDetailsId)->get()[0]['airplane_type'];
        $flightDetails = array();
        $passengers = array();
        $reference = [];

        $reference['paypalClientId'] = env('PAYPAL_CLIENT_ID');
        $reference['price'] = $totalCost;

        $flightDetails['flight_number'] = FlightDetails::where('id', $flightDetailsId)->get()[0]['flight_number'];
        $flightDetails['airline'] = FlightDetails::where('id', $flightDetailsId)->get()[0]['airline'];
        $flightDetails['airplane_img'] = Airplanes::findByType($airplaneType)->img;
        $flightDetails['airplane_type'] = $airplaneType;
        $flightDetails['source_city'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['source_airport'])[0];
        $flightDetails['destination_city'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['destination_airport'])[0];
        $flightDetails['source_iata'] = explode('%3E', explode('-', explode('connections=', $targetUrlOfPlaneChoosing)[1])[0])[0];
        $flightDetails['destination_iata'] = explode('%3E', explode('-', explode('connections=', $targetUrlOfPlaneChoosing)[1])[0])[1];
        $flightDetails['departure_date'] = explode(' ', FlightDetails::where('id', $flightDetailsId)->get()[0]['departure_date'])[0];
        $flightDetails['return_date'] = explode(' ', FlightDetails::where('id', $flightDetailsId)->get()[0]['return_date'])[0];

        $incrementKey = 1;

        foreach ($passengersId as $id){
            $passenger = Passenger::where('id', $id)->get();
            $pax = explode('-', $reservationUtilsPax);

            $passengers[$incrementKey]['serialNumber'] = $incrementKey;
            $passengers[$incrementKey]['name'] = $passenger[0]->first_name. ' ' .$passenger[0]->last_name;

            for($i = 0; $i < count($pax); $i++) {
                switch($i) {
                    case 0:
                    {
                        if ($pax[0] !== '0') {
                            for ($j = 0; $j < intval($pax[0]); $j++) {
                                $passengers[$incrementKey]['type'] = 'adult';
                            }
                        }
                        break;
                    }
                    case 1:
                    {
                        if ($pax[1] !== '0') {
                            for ($j = 0; $j < intval($pax[1]); $j++) {
                                $passengers[$incrementKey]['type'] = 'child';
                            }
                        }
                        break;
                    }
                    case 2:
                    {
                        if ($pax[2] !== '0') {
                            for ($j = 0; $j < intval($pax[2]); $j++) {
                                $passengers[$incrementKey]['type'] = 'infant';
                            }
                        }
                        break;
                    }
                    case 3:
                    {
                        if ($pax[3] !== '0') {
                            for ($j = 0; $j < intval($pax[3]); $j++) {
                                $passengers[$incrementKey]['type'] = 'senior';
                            }
                        }
                        break;
                    }
                    case 4:
                    {
                        if ($pax[4] !== '0') {
                            for ($j = 0; $j < intval($pax[4]); $j++) {
                                $passengers[$incrementKey]['type'] = 'youth';
                            }
                        }
                        break;
                    }
                    default:{}
                }
            }
            $incrementKey += 1;
        }

        return Inertia::render('Booking/Payment', [
            'title' => 'Trip summary',
            'progressId' => '5',
            'cost' => $totalCost,
            'isPrivate' => true,
            'reservationNumber' => explode('-', $reservation->reservation_number)[1],
            'baggages' => $baggages,
            'flightDetails' => $flightDetails,
            'passengers' => $passengers,
            'reference' => $reference
        ]);
    }

    public function payment()
    {

    }
}

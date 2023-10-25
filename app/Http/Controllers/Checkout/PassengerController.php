<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\FlightDetails;
use App\Models\Reservation;
use App\Models\ReservationCost;
use App\Models\ReservationUtils;
use App\Services\Payment\PaymentService;
use App\Services\Reservation\ReservationService;
use App\Services\Reservation\ReservationCostService;
use Inertia\Inertia;
use Inertia\Response;

class PassengerController extends Controller
{
    /**
     * Display create passenger resource page.
     *
     * @return Response
     */
    public function index(): Response
    {
        $passengers = [];
        $reservationId = ReservationService::getReservationId();

        $reservation = Reservation::find($reservationId);

        $reservationUtils = ReservationUtils::where('reservation_id', $reservationId)->first();

        $pax = explode('-', $reservationUtils->pax);

        $flightDetailsId = $reservation->flight_details_id;
        $flightDetails = FlightDetails::find($flightDetailsId)->get()->last();
        $isPrivate = ($flightDetails->cabin_class === 'individual');

        $paymentData = [
            'payment_amount' => ReservationCostService::getTotalCost(),
        ];
        PaymentService::updatePaymentStatus($reservationId, $paymentData);

        for($i = 0; $i < count($pax); $i++) {
            switch($i) {
                case 0:
                {
                    if ($pax[0] !== '0')
                    {
                        for ($j = 0; $j < intval($pax[0]); $j++)
                        {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Adult'
                            ];
                        }
                    }
                    break;
                }
                case 1:
                {
                    if ($pax[1] !== '0')
                    {
                        for ($j = 0; $j < intval($pax[1]); $j++)
                        {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Child'
                            ];
                        }
                    }
                    break;
                }
                case 2:
                {
                    if ($pax[2] !== '0')
                    {
                        for ($j = 0; $j < intval($pax[2]); $j++)
                        {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Infant'
                            ];
                        }
                    }
                    break;
                }
                case 3:
                {
                    if ($pax[3] !== '0')
                    {
                        for ($j = 0; $j < intval($pax[3]); $j++)
                        {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Senior'
                            ];
                        }
                    }
                    break;
                }
                case 4:
                {
                    if ($pax[4] !== '0')
                    {
                        for ($j = 0; $j < intval($pax[4]); $j++)
                        {
                            $passengers[] = [
                                'id' => count($passengers) + 1,
                                'type' => 'Youth'
                            ];
                        }
                    }
                    break;
                }
                default:{}
            }
        }
        return Inertia::render('Booking/CreatePassenger', [
            'title' => 'Set passengers',
            'progressId' => $isPrivate || $reservationUtils->travel_type === 'ONEWAY' ? '3' : '4',
            'cost' => ReservationCostService::getTotalCost(),
            'targetOfPlaneChoosing' => $reservationUtils->target_of_plane_choosing,
            'passengers' => $passengers,
            'isPrivate' => $isPrivate,
            'isRoundTrip' => $reservationUtils->travel_type === 'ROUNDTRIP'
        ]);
    }
}

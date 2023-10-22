<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Airplanes;
use App\Models\FlightDetails;
use App\Models\Passenger;
use App\Models\Reservation;
use App\Models\ReservationCost;
use App\Models\ReservationUtils;
use App\Services\Reservation\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Utils\TravelDaysCalculator;

class PaymentController extends Controller
{
    /**
     * Baggage adding and insurance page rendering.
     *
     * @return Response
     */
    public function index(): Response
    {
        $reservationService = new ReservationService();
        $reservation = Reservation::find($reservationService->getReservationId());
        $reservationUtils = ReservationUtils::where('reservation_id', $reservation->id)->get();
        //$baggages = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['checked_baggage_items'];
        $reservationUtilsPax = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['pax'];
        $targetUrlOfPlaneChoosing = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['target_of_plane_choosing'];
        $passengersId = $reservation->passengers->pluck('id');
        $totalCost = ReservationCost::where('reservation_id', $reservationService->getReservationId())->sum('price');
        $insuranceCost = ReservationCost::select('price')
                            ->where('reservation_id', $reservationService->getReservationId())
                            ->where('item_name', 'Insurance cost')
                            ->first();
        $flightDetailsId = $reservation->flight_details_id;
        $airplaneType = FlightDetails::where('id', $flightDetailsId)->get()[0]['airplane_type'];
        $flightDetails_ = FlightDetails::find($flightDetailsId)->get()->last();
        //$airplaneType = $flightDetails_->airplane_type;
        $isPrivate = ($flightDetails_->cabin_class === 'individual');
        $flightDetails = array();
        $passengers = array();
        $reference = [];

        $reference['paypalClientId'] = env('PAYPAL_SANDBOX_CLIENT_ID');
        $reference['price'] = $totalCost;

        $flightDetails['flight_number'] = FlightDetails::where('id', $flightDetailsId)->get()[0]['flight_number'];
        $flightDetails['airline'] = FlightDetails::where('id', $flightDetailsId)->get()[0]['airline'];
        $flightDetails['cabin_class'] = FlightDetails::where('id', $flightDetailsId)->get()[0]['cabin_class'];

        if ($isPrivate)
        {
            $baggages = ReservationUtils::where('reservation_id', $reservation->id)->get()[0]['checked_baggage_items'];
            $flightDetails['airplane_img'] = Airplanes::findByType($airplaneType)->img;
        }


        $flightDetails['airplane_type'] = $airplaneType;
        $flightDetails['source_city'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['source_airport'])[0];
        $flightDetails['destination_city'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['destination_airport'])[0];
        $flightDetails['source_airport'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['source_airport'])[1];
        $flightDetails['destination_airport'] = explode(',', FlightDetails::where('id', $flightDetailsId)->get()[0]['destination_airport'])[1];
        $flightDetails['source_iata'] = explode('%3E', explode('-', explode('connections=', $targetUrlOfPlaneChoosing)[1])[0])[0];
        $flightDetails['destination_iata'] = explode('%3E', explode('-', explode('connections=', $targetUrlOfPlaneChoosing)[1])[0])[1];
        $flightDetails['departure_date'] = explode(' ', FlightDetails::where('id', $flightDetailsId)->get()[0]['departure_date'])[0];
        $flightDetails['return_date'] = explode(' ', FlightDetails::where('id', $flightDetailsId)->get()[0]['return_date'])[0];

        if ($isPrivate)
        {
            $flightDetails['flight_cost'] = ReservationCost::where('item_name','Flight cost')->where('reservation_id', $reservation->id)->first()->price;
        } else {
            if ($reservationUtils->first()->travel_type === 'ROUNDTRIP')
            {
                $flightDetails['flight_cost'] = ReservationCost::where('item_name','Departure fligt cost')->where('reservation_id', $reservation->id)->first()->price
                    + ReservationCost::where('item_name','Return flight cost')->where('reservation_id', $reservation->id)->first()->price;
            } else {
                $flightDetails['flight_cost'] = ReservationCost::where('item_name','Departure fligt cost')->where('reservation_id', $reservation->id)->first()->price;
            }
        }

        $incrementKey = 1;

        $travelType = explode('&', explode('travel_type=', $targetUrlOfPlaneChoosing)[1])[0];

        foreach ($passengersId as $id){
            $passenger = Passenger::where('id', $id)->get();
            $pax = explode('-', $reservationUtilsPax);

            $passengers[$incrementKey]['serialNumber'] = $incrementKey;
            $passengers[$incrementKey]['name'] = $passenger[0]->first_name. ' ' .$passenger[0]->last_name;
            $passengers[$incrementKey]['checkedBaggages'] = $passenger[0]->amount_of_luggage;

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
            'progressId' => $isPrivate || $reservationUtils->first()->travel_type === 'ONEWAY' ? '5' : '6',
            'cost' => $totalCost,
            'isPrivate' => $isPrivate,
            'reservationNumber' => explode('-', $reservation->reservation_number)[1],
            'baggages' => $baggages,
            'flightDetails' => $flightDetails,
            'passengers' => $passengers,
            'reference' => $reference,
            'amountTravelDays' => TravelDaysCalculator::calculate(
                                    $flightDetails['departure_date'],
                                    $flightDetails['return_date']
                                  ),
            'travelType' => $travelType,
            'insuranceCost' => $insuranceCost->price,
            'isRoundTrip' => $reservationUtils->first()->travel_type === 'ROUNDTRIP'
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function paymentHandle(Request $request): RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder(
            [
                "intent" => "CAPTURE",
                'application_context' => [
                    'return_url' => route('payment-success'),
                    'cancel_url' => route('payment-cancel')
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $request->get('price')
                        ]
                    ]
                ]
            ]
        );

        if(isset($response['id']) && $response['id'] != null){
            foreach ($response['links'] as $link){
                if($link['rel'] == 'approve'){
                    //return redirect()->away($link['href']);
                    /*return response('', 409)
                        ->header('X-Inertia-Location', $link['href']);*/
                    return Inertia::location($link['href']);
                }
            }
        }

        return redirect(route('payment-cancel'));
    }

    /**
     * @param Request $request
     * @throws Throwable
     * @return RedirectResponse
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $reservationService = new ReservationService();
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->get('token'));

        if($response['status'] == 'COMPLETED'){
            $reservation = Reservation::find($reservationService->getReservationId());
            $reservation->paymentStatus()->update([
                'payment_status' => 'payed'
            ]);
        }
        return redirect(route('successfull-payment'));
    }

    /**
     * @return Response
     */
    public function paymentCancel(): Response
    {
        return Inertia::render('Payment/Cancel',[
            'title' => 'Payment Cancel',
            'text' => 'Your payment has been declend.'
        ]);
    }

    /**
     * @return Response
     */
    public function successfullPayment(): Response
    {
        return Inertia::render('Payment/Success',[
            'title' => 'Payment Success',
            'text' => 'Thank you for choosing us. The invoice and tickets have been sent to the e-mail address provided. Have a good trip.'
        ]);
    }
}

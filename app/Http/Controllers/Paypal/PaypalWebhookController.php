<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mdb\PayPal\Ipn\Event\MessageVerifiedEvent;
use Mdb\PayPal\Ipn\Event\MessageInvalidEvent;
use Mdb\PayPal\Ipn\Event\MessageVerificationFailureEvent;
use Mdb\PayPal\Ipn\ListenerBuilder\Guzzle\InputStreamListenerBuilder as ListenerBuilder;

class PaypalWebhookController extends Controller
{
    /**
     *
     */
    public static function verifyIPN()
    {
        $listenerBuilder = new ListenerBuilder();
        $listenerBuilder->useSandbox(); // use PayPal sandbox

        $listener = $listenerBuilder->build();

        $listener->onVerified(function (MessageVerifiedEvent $event) {
            $ipnMessage = $event->getMessage();

            // IPN message was verified, everything is ok! Do your processing logic here...
            //file_put_contents('outcome.txt', "VERIFIED\n\n$ipnMessage\n\n$session_id");
            file_put_contents('outcome.txt', $ipnMessage);
                //todo Reservation payment status is "B" billed
        });

        $listener->onInvalid(function (MessageInvalidEvent $event) {
            $ipnMessage = $event->getMessage();

            // IPN message was invalid, something is not right! Do your logging here...
            file_put_contents('outcome.txt', "INVALID\n\n$ipnMessage");
        });

        $listener->onVerificationFailure(function (MessageVerificationFailureEvent $event) {
            $error = $event->getError();

            // Something bad happend when trying to communicate with PayPal! Do your logging here...
            file_put_contents('outcome.txt', "VERIFICATION FAILURE\n\n$error");
        });

        $listener->listen();
    }

    public function useIpnMessage()
    {
        $ipnMessage = File::lines('outcome.txt')->each(function ($line) { return $line; });
        $ipn_message = array();

        foreach (explode('&',$ipnMessage) as $item) {
            $ipn_message[explode('=', $item)[0]] = str_replace('%40', '@', explode('=', $item)[1]);
        }

        $userEmail = $ipn_message['payer_email'];
        $user = UserRepository::findByEmail($userEmail)->first();
        $session_id = DB::table('sessions')
            ->select('id', 'last_activity')
            ->where('user_id', $user['id'])
            ->orderBy('last_activity', 'desc')
            ->get()
            ->first();

    }
}

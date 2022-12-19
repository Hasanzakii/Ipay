<?php

use App\Models\OnlainePayment;
use App\Models\Online_payment;
use App\Models\OnlinePayment;
use Illuminate\Http\Client\RequestException;
use Zarinpal\Clients\GuzzleClient;
use Zarinpal\Zarinpal;
use Request;

class PaymentService
{
    public function paymentCallback()
    {
        $amount = 0;
        # recive the amount back & check if is equal what should user pay and retive result
        $result = $this->zarinpalVerify($amount);
        if ($result['success']) {
            return 'ok';
        }
    }
    public function zarinpal()
    {
        $amount = 0;
        $sandbox = false;
        $zarinpalGate  = false;
        $merchentID = 1232432423;
        $zarinpalGatePSP = '';
        $client = new GuzzleClient($sandbox);
        $lang = 'fa';
        $zarinpal = new Zarinpal($merchentID, $client, $lang, $sandbox, $zarinpalGate, $zarinpalGatePSP);
        $payment = [
            'callbackurl' => route('payment_callback'),
            'amount' => $amount
        ];
        try {
            $response = $zarinpal->request($payment);
            $onlinepayment = OnlinePayment::first();
            $code = $response['data']['code'];
            $message = $zarinpal->getCodeMessage($code);
            if ($code === 100) {
                $onlinepayment->update(['bank_first_response' => ($response)]);
                #کد یکتا برای هر درخواست
                $authority = $response['data']['authority'];
                #return verify page check payment with amount and authority
                return $zarinpal->redirect($authority);
            }
        } catch (RequestException $exeption) {
            return false;
        }
    }


    public function zarinpalVerify($amount)
    {
        $authority = $_GET['Authority'];
        $data = ['merchent_id' => ('13245646'), 'authority' => $authority, 'amount' => (int)$amount];
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $onlinepayment = OnlinePayment::first();
        $onlinepayment->update([
            'bank_second_response' => 'result'
        ]);
        if (count($result['errors']) === 0) {
            if ($result['data']['code'] == 100) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }
    }
}

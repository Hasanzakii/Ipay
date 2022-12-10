<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CryptoGatewayController extends Controller
{
    public function setTxid(Request $request)
    {
        $validated = $request->validate([
            'txid' => 'required|unique:payments',
            'fee' => 'required'
        ]);
        $ourWallet = "0xA76bF4EF64A8C4aEf29c0b11ac5891DaA8E05d39"; #ETH Wallet
        $client = new Client();
        $url = "https://apilist.tronscan.org/api/transaction-info?hash=" . $request->txid;
        $res = $client->request('GET', $url);
        if ($res->getBody() != null and $res->getStatusCode() == 200) {
            $data = json_decode($res->getBody());
            if (isset($data->contractRet) and $data->contractRet == 'SUCCESS' and isset($data->confirmed) and $data->confirmed == true) {
                if ($data->transfersAllList[0]->to_address == $ourWallet and $data->transfersAllList[0]->symbol == "USDT" and $data->transfersAllList[0]->contract_address == "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t" and $data->transfersAllList[0]->amount_str / 1000000 >= 1) {
                    $from = $data->transfersAllList[0]->from_address;
                    $fee = $data->transfersAllList[0]->amount_str / 1000000;

                    //Check if the fee == $request->fee then fill the payment
                    if ($fee == $request->fee) {


                        $time = $data->timestamp;
                        $nickname = $request->nickname ?? null;
                        $new_payment = Payment::where('user_id', Auth::user()->id)->create([
                            'from_pubkey' => $from,
                            'to_pubkey' => $ourWallet,
                            'txid' => $request->txid,
                            'nickname' => $nickname,
                            'txtime' => $time,
                            'fee' => $fee,

                        ]);

                        //increase & decrease th balance
                        Payment::where('user_id', auth()->user()->id)->increment(
                            'Balance',
                            $request->fee
                        );
                        $payment = Payment::where('user_id', auth()->user()->id)->get();
                        return response()->json([
                            $payment
                        ]);


                        return response()->json([
                            $new_payment,
                            'status' => 1,
                            'desc' => "done"
                        ]);
                    }
                } else
                    throw ValidationException::withMessages(['desc' => 'txid is not belong to IPay']);
            }
        }
        throw ValidationException::withMessages(['desc' => 'tron chain error']);
    }
}

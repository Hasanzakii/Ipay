<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CryptoPayment;
use App\Models\OnlinePayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Database\Query\Builder;
use PaymentService;
use Pishran\Zarinpal\Zarinpal;
use Quest\Macros\WhereFuzzy;

use function GuzzleHttp\Promise\all;

class ShopController extends Controller
{

    //return all orders for specific user with eager loading to avoid lazy loading
    public function GetOrder(Request $request)
    {
        // $order = Order::where('user_id', Auth::user()->id)
        //     ->join('products', 'products.id', '=', 'orders.product_id')
        //     ->join('brands', 'brands.id', '=', 'products.brand_id')
        //     ->get();

        #Eager Loading
        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 3)->with('product.brand')->get();

        return response()->json($order);
    }

    //return all brand
    public function brands(Request $request)
    {
        $brands = Brand::all();
        return response()->json($brands);
        #Redislrhdsi 
        // $brand = Cache::remember('brands', 33600, function () {
        //     return Brand::all();
        // });
    }
    public function testAdmin()
    {
        return "Admin";
    }

    //return Product related to each brand
    public function ProductOfBrands(Request $request)
    {

        $products = Product::where('brand_id', $request->brand_id)->get();
        return response()->json($products);


        // $brands = Product::find(1)->brands;
        // dd($brands);
    }


    //CreateOrder for the user whose status is equal to "0"
    public function CreateOrder(Request $request)
    {
        $user = Auth::user();
        //Validation Inputs
        $validation = Validator::make($request->all(), [

            'product_id' => 'required'

        ])->validate();

        //Create Order for logged in user
        $order = Order::Create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
        ]);
        $UserOrder = Order::where('user_id', Auth::user()->id)->with('product.brand')->latest()->first();
        if ($order) {
            $msg = 'order created successfully Honey :D ';
            return response()->json(

                $UserOrder,
                200

            );
        } else {
            $msg2 = ['failed'];
            return response()->json([
                $msg2,
            ], 401);
        }
    }
    public function RedirectToUrl(Request $request)
    {

        return redirect('https://witel.ir/');
    }
    public function search($name)
    {
        // return Brand::where("brand_name", "like", "%" . $name . "%")->get();
        $brandname = Brand::whereFuzzy('brand_name', $name)
            ->first();
        return $brandname;
    }
    public function buy()
    {
        return view('shop');
    }

    public function paymentSubmit(Request $request, Zarinpal $zarinpal)
    {
        $userid = Auth::user()->id;
        $order = Order::where('user_id', $userid)->where('order_status', 0)->first();
        // switch ($request->payment_type) {
        //     case '1':
        //         $targetModel = OnlinePayment::class;
        //         $type = 0;
        //         break;
        //     case '2':
        //         $targetModel2 = CryptoPayment::class;
        //         $type = 1;
        //         break;
        // }
        $onlinepayment = OnlinePayment::create([
            'user_id' => $userid,
        ]);



        // $payment = Payment::create(
        //     [
        //         'amount' => $order->order_final_amount,
        //         'user_id' => auth()->user()->id,
        //         'pay_date' => now(),
        //         'type' => $type,
        //         'paymentable_id' => $paymented->id,
        //         'paymentable_type' => $targetModel,
        //         'staus' => 1]);
    }

    public function paymentCallback()
    {
        $amount = 0;
        # recive the amount back & check if is equal to what user should pay and retive result
        $result = $this->zarinpalVerify($amount);
        if ($result['success']) {
            return 'ok';
        }
    }
}

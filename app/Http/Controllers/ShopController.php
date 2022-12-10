<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
        #Redis
        // $brand = Cache::remember('brands', 33600, function () {
        //     return Brand::all();
        // });
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
}

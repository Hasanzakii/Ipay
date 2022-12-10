<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //AddBrand
    public function AddBrand(Request $request)
    {
        //Validation Request
        $rules = ['brand_name' => 'required'];
        $request->validate($rules);
        //get image in file format with "photo" key that come from request -> key:photo => value:image 
        $image = $request->file('photo');
        //upload file using Storage Facade 
        $test = Storage::disk('public')->put('storage/apiDocs', $image);
        // $url = Storage::disk('public')->url($test);

        //Add Brand
        $NewBrand = new Brand();
        $NewBrand->brand_name = $request->brand_name;
        $NewBrand->brand_image = $test;
        $result = $NewBrand->save();
        if ($result) {

            $msg = ['Brand Added Successfully honey :D'];
            return response()->json([
                'message' => $msg,
                'newBrand' => $NewBrand,
                200
            ]);
        } else {

            $msg = ['Failed'];
            return response()->json($msg, 401);
        }
    }
    //Update
    public function UpdateBrand(Request $request)
    {
        $rules = ['id' => 'required|exists:brands'];
        $request->validate($rules);
        $image = $request->file('photo');
        $test = Storage::disk('public')->put('apiDocs', $image);
        // $url = Storage::disk('public')->url($test);
        Brand::where('id', $request->id)->update([
            // 'brand_name' => $request->brand_name,
            'brand_image' => $test,

        ]);
        $brand =  Brand::where('id', $request->id)->get();
        return response()->json([
            'UpdatedBrand' => $brand,
            'message' =>  'Updated Successfully'
        ]);
    }

    //AddProduct
    public function DeleteBrand(Request $request)
    {

        $validation = Validator::make($request->all(), [

            'id' => 'required|exists:brands'
        ]);
        if (!$validation) {
            return 'failed';
        }
        Brand::where('id', $request->id)->delete();
    }
    #Add NewProduct
    public function AddProduct(Request $request)
    {
        Validator::make($request->all(), [
            'price' => 'required',
            'brand_id' => 'required'
        ])->validate();
        $newproduct = Product::Create([
            'brand_id' => $request->brand_id,
            'product_name' => $request->product,
            'price' => $request->price
        ]);
        if ($newproduct) {
            return response()->json([
                'msg' => 'New product added succefully',
                'NewProduct' => $newproduct,
            ]);
        } else {
            return response()->json([
                'msg' => 'Failed nothing sdded'
            ]);
        }
    }
    #DeleteProduc
    public function DeleteProduct(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required|exists:products',

        ])->validate();
        $deletedProduct = Product::where('id', $request->id)->delete();
        if ($deletedProduct) {
            return response()->json([
                'msg' => 'product deleted succefully',
            ]);
        } else {
            return response()->json([
                'msg' => 'Failed nothing deltede'
            ]);
        }
    }
}

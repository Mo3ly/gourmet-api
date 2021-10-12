<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuProduct;
use App\Models\Media;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;

class ProductController extends Controller
{
    public function index(){
        return new ProductResourceCollection(MenuProduct::all());
    }

    public function store(Request $request){
        $request->validate([
            'category_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'desc_en' => 'required',
            'desc_ar' => 'required',
            'price' => 'required',
            'isNew' => 'required',
            'isSpecial' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imageName = time().'.'.$request->image->getClientOriginalExtension();  
     
        $request->image->move(public_path('images'), $imageName);

        $image = Media::create([
            'title' => $request->name_en,
            'type' => 'photo',
            'url' => env('APP_URL') . '/images/' . $imageName,
            'created_at' => null
        ]);

        $product =  MenuProduct::create([
            'category_id' => $request->category_id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'desc_en' => $request->desc_en,
            'desc_ar' => $request->desc_ar,
            'price' => $request->price,
            'isNew' => $request->isNew == true ? 1 : 0,
            'isSpecial' => $request->isSpecial == true ? 1 : 0,
            'media_id' => $image->id,
        ]);

        return response()->json(['success'=>'The new product has been added successfully.']);
    }
    
    public function update(Request $request){
        $request->validate([
            'product_id' => 'required',
        ]);

        $product = MenuProduct::find($request->product_id);

        if($product) {
            $request->name_en ? $product->name_en = $request->name_en : null;
            $request->name_ar ? $product->name_ar = $request->name_ar : null;
            $request->desc_en ? $product->desc_en = $request->desc_en : null;
            $request->desc_ar ? $product->desc_ar = $request->desc_ar : null;
            $request->price ? $product->price = $request->price : null;
            $request->isNew ? $product->isNew = ($request->isNew === 'true' ? 1 : 0) : null;
            $request->isSpecial ? $product->isSpecial = ($request->isSpecial === 'true' ? 1 : 0) : null;
            
            if($request->has('image')){
                $request->validate([
                    'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ]);
                $imageName = time().'.'.$request->image->getClientOriginalExtension();  
            
                $request->image->move(public_path('images'), $imageName);
    
                $image = Media::create([
                    'title' => 'image',
                    'type' => 'photo',
                    'url' => env('APP_URL') . '/images/' . $imageName,
                    'created_at' => null
                ]);
                
                $product->media_id = $image->id;
            }

            $product->save();
        } else return;

        return response()->json(['success'=>'The new product has been updated. ']);
    }

    public function destroy(Request $request){
        $request->validate([
            'product_id' => 'required',
        ]);
        
        $product = MenuProduct::find($request->product_id);
        $product->delete();

        return response()->json(['success'=>'The new product has been deleted.']);
    }
}

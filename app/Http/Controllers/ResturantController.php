<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\Media;
use App\Http\Resources\ResturantResource;
use App\Http\Resources\ResturantResourceCollection;

class ResturantController extends Controller
{   
    public function index(){
        return new ResturantResourceCollection(Resturant::orderBy('id')->get());
    }
    
    public function show($name){
        return new ResturantResource(Resturant::where('name_en', $name)->firstOrFail());
    }

    public function store(Request $request){
        $request->validate([
            'name_en' => 'required',
            'name_ar' => 'required',
            'desc_en' => 'required',
            'desc_ar' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imageName = time().'.'.$request->image->getClientOriginalExtension();  
     
        $imagePath = $request->image->storeAs('public/resturants', $imageName);

        $image = Media::create([
            'title' => $request->name_en,
            'type' => 'photo',
            'url' => env('APP_URL') . '/storage/resturants/' . $imageName,
            'created_at' => null
        ]);

        $resturant =  Resturant::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'desc_en' => $request->desc_en,
            'desc_ar' => $request->desc_ar,
            'category' => $request->category,
            'media_id' => $image->id,
        ]);

        // return new ResturantResource($resturant);
        return response()->json(['success'=>'The new resturant has been added successfully.']);
    }
    
    public function update(Request $request){
        $request->validate([
            'resturant_id' => 'required',
        ]);

        $resturant = Resturant::find($request->resturant_id);

        if($resturant) {
            $request->name_en ? $resturant->name_en = $request->name_en : null;
            $request->name_ar ? $resturant->name_ar = $request->name_ar : null;
            $request->desc_en ? $resturant->desc_en = $request->desc_en : null;
            $request->desc_ar ? $resturant->desc_ar = $request->desc_ar : null;
            $request->category ? $resturant->category = $request->category : null;

            
            if($request->has('image')){
                $request->validate([
                    'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ]);
                $imageName = time().'.'.$request->image->getClientOriginalExtension();  
            
                $imagePath = $request->image->storeAs('public/resturants', $imageName);
    
                $image = Media::create([
                    'title' => 'image',
                    'type' => 'photo',
                    'url' => env('APP_URL') . '/storage/resturants/' . $imageName,
                    'created_at' => null
                ]);
                
                $resturant->media_id = $image->id;
            }

            $resturant->save();
        } else return;

        return response()->json(['success'=>'The resturant has been updated.']);
    }

    public function destroy(Request $request){
        $request->validate([
            'resturant_id' => 'required',
        ]);
        
        $resturant = Resturant::find($request->resturant_id);
        $resturant->delete();       

        return response()->json(['success'=>'The resturant has been deleted.']);
    }
}

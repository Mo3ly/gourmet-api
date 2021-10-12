<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;

use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'resturant_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);

        $category =  MenuCategory::create([
            'resturant_id' => $request->resturant_id,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'desc_en' => '-',
            'desc_ar' => '-',
        ]);

        return response()->json(['success'=>'The new resturant has been added successfully.']);
    }
    
    public function update(Request $request){
        $request->validate([
            'category_id' => 'required',
        ]);

        $category = MenuCategory::find($request->category_id);

        if($category) {
            $request->name_en ? $category->name_en = $request->name_en : null;
            $request->name_ar ? $category->name_ar = $request->name_ar : null;
        } else return;

        $category->save();

        return response()->json(['success'=>'This category has been updated.']);
    }

    public function destroy(Request $request){
        $request->validate([
            'category_id' => 'required',
        ]);
        
        $category = MenuCategory::find($request->category_id);
        $category->delete();       

        return response()->json(['success'=>'The category has been deleted.']);
    }
}

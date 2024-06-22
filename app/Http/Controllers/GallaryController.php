<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GallaryController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'dress_type' => 'required|string',
            'season_type' => 'required|string',
            'type'      =>'required|string',
            'name' => 'required|string',
        ]);
       
        $gallery = DB::table('gallery')->insert([
            'user_id' =>Auth::user()->id,
            'image' => $request->image,
            'dress_type' => $request->dress_type,
            'season_type' => $request->season_type,
            'name' => $request->name,
        ]);

        return response()->json($gallery, 201);
    }

    public function view(Request $request)
    {
        $data = DB::table('gallery')->where('user_id',1)->get();
        foreach($data as $single)
        {
           
            // $single->image = base64_decode($single->image);
            // dd($single->image);
        }
        return response()->json(['status'=>true,'data'=>$data],201);
    }

    public function update(Request $request)
    {

        $request->validate([
            'image' => 'sometimes|image',
            'dress_type' => 'sometimes|string',
            'season_type' => 'sometimes|string',
            'type'      =>'sometimes|string',
            'name' => 'sometimes|string',
        ]);

        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
            $gallery = DB::table('gallery')->where('user_id',Auth::user()->id)->where('id',$request->id)->update([
                'image' => $imageData,
                'dress_type' => $request->dress_type,
                'season_type' => $request->season_type,
                'name' => $request->name,
            ]);
        }

        $gallery->update($request->only(['dress_type', 'season_type', 'name']));

        return response()->json($gallery);
    }

    public function delete(Request $request)
    {
        DB::table('gallery')->where('user_id',Auth::user()->id)->where('id',$request->id)->delete();

        return response()->json(['status'=>true,'message'=>'Delete Successfully.'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
        $apiKey = '878670bc3b0ce7251b76832e39ba7c94';
        $imageData = $request->input('image');
        if (strpos($imageData, 'data:image') === 0) {
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        } else {
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
            } else {
                return response()->json([
                    'message' => 'Invalid image data',
                ], 400);
            }
        }
        $response = Http::asForm()->post("https://api.imgbb.com/1/upload", [
            'key' => $apiKey,
            'image' =>$imageData,//base64_encode($request->image),
            'expiration' => 600,  // Set expiration if needed
        ]);
        if ($response->successful()) {
            $responseData = $response->json();

            $gallery = DB::table('gallery')->insert([
                'user_id'         =>Auth::user()->id,
                'image'           => $responseData['data']['url'],
                'dress_type'      => $request->dress_type,
                'season_type'     => $request->season_type,
                'image_thumbnail' => $responseData['data']['thumb']['url'],
                'name'            => $request->name,
            ]);
    
            return response()->json(['status'=>true,'messgae'=>'wardrode created successfully.'], 200);
        } else {
            $errorResponse = $response->json();
            return response()->json([
                'message' => 'Image upload failed',
                'error' => $errorResponse,
            ], $response->status());
        }
       
       
    }

    public function view(Request $request)
    {

        $data = DB::table('gallery')->where('user_id',Auth::user()->id)->get();
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
        if($request->hasFile('image'))
        {
        $apiKey = '878670bc3b0ce7251b76832e39ba7c94';
        $imageData = $request->input('image');
        if (strpos($imageData, 'data:image') === 0) {
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        } else {
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
            } else {
                return response()->json([
                    'message' => 'Invalid image data',
                ], 400);
            }
        }
        $response = Http::asForm()->post("https://api.imgbb.com/1/upload", [
            'key' => $apiKey,
            'image' => $request->image,
            'expiration' => 600,  // Set expiration if needed
        ]);
        if ($response->successful()) {
            $responseData = $response->json();
            DB::table('gallery')->where('user_id',Auth::user()->id)->where('id',$request->id)->update([
                'image' => $responseData['data']['url'],
                'dress_type' => $request->dress_type,
                'season_type' => $request->season_type,
                'name' => $request->name,
                'image_thumbnail' => $responseData['data']['thumb']['url']
            ]);
            return response()->json([
                'message' => 'wardrobe updated successfully.',
                'status' => true,
            ],200);
        }
        else{
            $errorResponse = $response->json();
            return response()->json([
                'message' =>$errorResponse,
                'status' =>false ,
            ], 422);
        }

        }
        else
        {
            DB::table('gallery')->where('user_id',Auth::user()->id)->where('id',$request->id)->update([
                'image' => $request->image,
                'dress_type' => $request->dress_type,
                'season_type' => $request->season_type,
                'name' => $request->name,
                'image_thumbnail' => $request->image_thumbnail
            ]);
            return response()->json([
                'message' => 'wardrobe updated successfully.',
                'status' => true,
            ],200);
        }
    }

    public function delete(Request $request)
    {
        DB::table('gallery')->where('user_id',Auth::user()->id)->where('id',$request->id)->delete();

        return response()->json(['status'=>true,'message'=>'Delete Successfully.'], 200);
    }
}

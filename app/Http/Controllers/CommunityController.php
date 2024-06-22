<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunityController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:20480', // 20MB max
        ]);

        $mediaData = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $mediaData = file_get_contents($request->file('media')->getRealPath());
            $mediaType = $request->file('media')->getMimeType();
        }

        $community = DB::table('community')->create([
            'content' => $request->content,
            'media' => $mediaData,
            'media_type' => $mediaType,
        ]);

        return response()->json($community, 201);
    }

    public function view(Request $request)
    {

        $data = DB::table('community')->get();
        return response()->json([
           'status'=>true,
           'data' => $data
        ],200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'sometimes|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:20480', // 20MB max
        ]);

        if ($request->hasFile('media')) {
            $mediaData = file_get_contents($request->file('media')->getRealPath());
            $mediaType = $request->file('media')->getMimeType();
            $community = DB::table('community')->where('user_id',1)->where('id',$request->id)->update([
                'content' => $request->content,
                'media' => $mediaData,
                'media_type' => $mediaType,
            ]);
        }
        else{
            $community = DB::table('community')->where('user_id',1)->where('id',$request->id)->update([
                'content' => $request->content,
                // 'media' => $mediaData,
                // 'media_type' => $mediaType,
            ]);
        }
        return response()->json(['status'=>true,'message'=>'Updated Successfully!'],200);
    }

    public function delete(Request $request)
    {
        DB::table('community')->where('user_id',1)->where('id',$request->id)->delete();
        return response()->json(['status'=>true,'message'=>'Deleted Successfully!'], 204);
    }
}

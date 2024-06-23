<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CommunityController extends Controller
{
    //

    private function uploadImage($request)
    {
       
        // return $response;

    }
    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:20480', // 20MB max
        ]);

        $mediaData = null;
        $mediaType = null;

        if ($request->hasFile('media')) 
        {
            $apiKey = '878670bc3b0ce7251b76832e39ba7c94';
            $imageData = $request->input('media');
            if (strpos($imageData, 'data:image') === 0) 
            {
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            } 
            else 
            {
                if ($request->hasFile('media')) 
                {
                    $imageFile = $request->file('media');
                    $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                } 
                else 
                {
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
                $community = DB::table('community')->insert([
                'user_id'    => Auth::user()->id,
                'content'    => $request->content,
                'media'      => $responseData['data']['url'],
                'media_type' => $mediaType,
                ]);
            }
            else 
            {
                $errorResponse = $response->json();
                return response()->json([
                    'message' => $errorResponse,
                    'status' => false,
                ], 422);
            }
            return response()->json(['status'=>true,'message'=> "Post Created Successfully."], 200);
        }
        else
        {
            $community = DB::table('community')->insert([
            'user_id'    => Auth::user()->id,
            'content'    => $request->content,
            'media'      => $mediaData,
            'media_type' => $mediaType,
            ]);
            return response()->json(['status'=>true,'message'=> "Post Created Successfully."], 200);
        }
    }

    public function view(Request $request)
    {
        $posts = DB::table('community')->get();
        $comments = DB::table('comments')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->select('comments.*', 'users.name as user_name')
        ->get()
        ->groupBy('post_id');
        $data = $posts->map(function($post) use ($comments) {
        $post->comments = isset($comments[$post->id]) ? $comments[$post->id] : [];
        return $post;});
        return response()->json(['status'=>true,'data' => $data],200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'sometimes|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:20480', // 20MB max
        ]);

        if ($request->hasFile('media')) {
            $apiKey = '878670bc3b0ce7251b76832e39ba7c94';
            $imageData = $request->input('media');
            if (strpos($imageData, 'data:image') === 0) 
            {
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
            } 
            else 
            {
                if ($request->hasFile('media')) 
                {
                    $imageFile = $request->file('media');
                    $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
                } 
                else 
                {
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
                $community = DB::table('community')->where('user_id',1)->where('id',$request->id)->update([
                    'content' => $request->content,
                    'media' => $responseData['data']['url'],
                    'media_type' => $request->media_type,
                ]);
              
            }
            else 
            {
                $errorResponse = $response->json();
                return response()->json([
                    'message' => $errorResponse,
                    'status' => false,
                ], 422);
            }
            
        }
        else{
            $community = DB::table('community')->where('user_id',1)->where('id',$request->id)->update([
                'content' => $request->content,
                'media' => $request->media,
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

    public function Comments(Request $request)
    {

        $post=DB::table('community')->where('id',$request->post_id)->first();
        if($post)
        {
            DB::table('comments')->insert([
                'post_id'  => $request->post_id,
                'user_id'  => Auth::user()->id,
                'comment' => $request->comment
                ]);
                return response()->json(['status'=>true,'message'=>'comment posted successfully.'],200);
        }
        else
        {
            return response()->json(['status'=>false,'message'=>'post Not Fond'],422);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    //
public function contactUs(Request $request)
    {

        DB::table('contact_us')->insert([
            'email' => $request->email,
            'message' =>$request->message,
            'subject' =>$request->subject
        ]);
        return response()->json(['status'=>true,'message'=>'Submited Successfully.'],200);
    }
}

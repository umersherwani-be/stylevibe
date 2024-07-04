<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Stringable;

class OutfitController extends Controller
{
    // public function suggestOutfits(Request $request)
    // {
    //     $temperature = 15; // Example temperature
    //     $wardrobeData = [
    //         // Example wardrobe data
    //         // [
    //             "temperature" => 26,
    //             "data" => [
    //                 ["dress_type" => "top", "season_type" => "summer", "name" => "T-Shirt A", "id" => 1],
    //                 ["dress_type" => "bottom", "season_type" => "summer", "name" => "Jeans A", "id" => 2],
    //                 ["dress_type" => "bottom", "season_type" => "summer", "name" => "Shorts A", "id" => 3],
    //                 ["dress_type" => "top", "season_type" => "summer", "name" => "Shirt A", "id" => 4],
    //                 ["dress_type" => "top", "season_type" => "summer", "name" => "Sweater A", "id" => 5],
    //                 ["dress_type" => "outerwear", "season_type" => "summer", "name" => "Jacket A", "id" => 6],
    //                 ["dress_type" => "traditional-lower", "season_type" => "summer", "name" => "Shalwar", "id" => 7],
    //                 ["dress_type" => "traditional-upper", "season_type" => "summer", "name" => "Kameez", "id" => 8],
    //                 ["dress_type" => "outerwear", "season_type" => "summer", "name" => "Coat", "id" => 9]
    //             ]
    //         // ]
    //     ];
      
    //     $input_json=json_encode($wardrobeData);
   
    //     $scriptPath = base_path('scripts\ML-Model.py');

        
        
    //     $command = "python3 B:\\fyp_project\\stylevibe\\scripts\\ML-Model.py $input_json";
    //     $output = shell_exec($command);
    //     dd($output);
    //     $outfitSuggestions = json_decode($output, true);

    //     return response()->json($outfitSuggestions);
    // }

    public function suggestOutfits(Request $request)
{
    // $temperature = 15; // Example temperature
    $data=DB::table('gallery')->where('user_id',$request->id)->get();
    
    $wardrobeData = [
        [
        "temperature" => $request->temperature,
        "data" => $data
        ]
        ];
    $jsonData = json_encode($wardrobeData, JSON_PRETTY_PRINT);

    // Define the file path and name
    $folderPath = 'wardrobe_set';
    $fileName = "wardrobeData$request->id.json";
    $filePath = $folderPath . '/' . $fileName;

    // Create the directory if it doesn't exist
    if (!Storage::disk('local')->exists($folderPath)) {
        Storage::disk('local')->makeDirectory($folderPath);
    }

    Storage::disk('local')->put($filePath, $jsonData);
    $fullFilePath = storage_path('app/' . $filePath);
    // Path to your Python script
    $scriptPath = base_path('scripts/ML-Model.py');

    // Construct the command to execute the Python script with the JSON file path as an argument
    // dd($fullFilePath);
    $command = escapeshellcmd("python3 $scriptPath $fullFilePath");

    // Execute the command and capture the output
    $output = shell_exec($command);
    $result=json_decode($output);
    $finaldata=[];
    foreach($result as $single)
    {
        // $gets1=DB::table('gallery')->where('id',$single->id1)->where('user_id',$request->id)->first();
        // $gets2=DB::table('gallery')->where('id',$single->id2)->where('user_id',$request->id)->first();
        if(isset($single->id3) && isset($single->id2) && isset($single->id3) )
        {
            $items = DB::table('gallery')
            ->whereIn('id', [$single->id1, $single->id2,$single->id3])
            ->where('user_id', $request->id)
            ->get();
            array_push($finaldata,$items);
        }
        else{
            $items = DB::table('gallery')
            ->whereIn('id', [$single->id1, $single->id2])
            ->where('user_id', $request->id)
            ->get();
            array_push($finaldata,$items);
        }
      
        // dd($items);
    //    if($single->id3)
    //     {
    //     $gets2=DB::table('gallery')->where('id',$single->id3)->where('user_id',$request->id)->first();
        
    //     }
    //     else{ 
    // $wardrobeData = [$gets1, $gets2];  // Combine the two objects into a single array;
        // dd($wardrobeData);
           
            // dd($finaldata);

        // }
        // dd($finaldata);

    }

    return response()->json(['status'=>true,'data'=>$finaldata],200);

}

}


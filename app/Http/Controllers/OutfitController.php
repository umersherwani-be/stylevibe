<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutfitController extends Controller
{
    //
    public function suggestOutfits(Request $request)
    {
        // Validate the input
        $request->validate([
            'season' => 'required|string',
        ]);

        // Get the input season
        $season = $request->input('season');
        $inputFile = storage_path('app/wardrobe-payload.json'); // Ensure your JSON file is in the storage/app directory

        // Run the Python script
        $command = escapeshellcmd("python3 " . base_path('path/to/wardrobe.py') . " " . escapeshellarg($season) . " " . escapeshellarg($inputFile));
        $output = shell_exec($command);

        // Decode the JSON output from the Python script
        $outfits = json_decode($output, true);

        return response()->json($outfits);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\GolferResource;
use App\Models\Golfer;
use Illuminate\Http\Request;

class GolferController extends Controller
{

    /**
     *Gibt die 500 nächstgelegenen Golfer als JSON Antwort zurück
     */
    public function nearby(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];

        $golfers = Golfer::nearby($latitude, $longitude);

        return GolferResource::collection($golfers)
            ->additional([
                'total_golfers' => $golfers->count(),
            ]);
    }

}

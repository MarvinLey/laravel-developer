<?php

namespace App\Http\Controllers;

use App\Http\Resources\GolferResource;
use App\Models\Golfer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     *Gibt die 500 nächstgelegenen Golfer als CSV zum Download zurück
     */
    public function nearbyCsv(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];

        $golfers = Golfer::nearby($latitude, $longitude);

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=golfers_nearby.csv",
        ];

        $columns = [
            'id', 'debitor_account', 'name', 'email', 'latitude', 'longitude', 'distance (km)'
        ];

        $callback = function() use ($golfers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($golfers as $golfer) {
                fputcsv($file, [
                    $golfer->id,
                    $golfer->debitor_account,
                    $golfer->name,
                    $golfer->email,
                    $golfer->latitude,
                    $golfer->longitude,
                    round($golfer->distance, 2),
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golfer extends Model
{
    /** @use HasFactory<\Database\Factories\GolferFactory> */
    use HasFactory;

    protected $fillable = [
        'debitor_account',
        'name',
        'email',
        'born_at',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'debitor_account' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'born_at' => 'immutable_date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     *Gibt, anhand der Haversine Formel, die nächstgelegenen Golfer zurück
     */

    public static function nearby(float $latitude, float $longitude, int $limit = 500)
    {
     return static::query()
     ->select('*')
     ->selectRaw('
        (6371 * acos(
            cos(radians(?)) * cos(radians(latitude)) *
            cos(radians(longitude) - radians(?)) +
            sin(radians(?)) * sin(radians(latitude))
        )) AS distance
     ', [$latitude, $longitude,$latitude ])
     ->orderBy('distance')
     ->limit($limit)
     ->get();
    }
}

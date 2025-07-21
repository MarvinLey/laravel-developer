<?php

namespace Database\Seeders;

use App\Models\Golfer;
use Illuminate\Database\Seeder;

class GolferSeeder extends Seeder
{
    public function run(): void
    {

        /**
         * Task 2:
         * Fügt 100 Golfer mit fortlaufenden debitor_account Nummern hinzu
         * Der aktuell höchste vergebene debitor_account wird abgefragt und der nächste freie Wert wird verwendet.
         * Ergebnis: keine Duplikate mehr bei mehrfachem Durchlauf des Seeders
         */

        $lastDebitorNumber = Golfer::max('debitor_account') ?? 999;

        Golfer::factory()
            ->count(100)
            ->sequence(fn ($sequence) => [
                'debitor_account' => $lastDebitorNumber + 1 + $sequence->index,
            ])
            ->create();
    }
}

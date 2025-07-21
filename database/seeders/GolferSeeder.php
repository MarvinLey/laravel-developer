<?php

namespace Database\Seeders;

use App\Models\Golfer;
use Illuminate\Database\Seeder;

class GolferSeeder extends Seeder
{
    public function run(): void
    {

        /**
         * Task 1:
         * Erstellt 100 Golfer mit fortlaufenden debitor_account Nummern von 1000 bis 1099
         * Bei jedem Durchlauf des Seeders werden dieselben debitor_account Nummern vergeben.
         */

        Golfer::factory()
            ->count(100)
            ->sequence(fn ($sequence) => [
                'debitor_account' => 1000 + $sequence->index,
            ])
            ->create();
    }
}

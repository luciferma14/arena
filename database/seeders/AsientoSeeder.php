<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\Asiento;
use Illuminate\Database\Seeder;

class AsientoSeeder extends Seeder
{
    public function run(): void
    {
        $sectores = Sector::all();
        $totalAsientos = 0;

        foreach ($sectores as $sector) {
            $asientos = $this->generarAsientosPorSector($sector);
            $totalAsientos += count($asientos);
        }

        $this->command->info("✅ Asientos creados: {$totalAsientos}");
    }

    private function generarAsientosPorSector(Sector $sector): array
    {
        $asientos = [];

        if (preg_match('/^Sector (10[1-9]|1[1-2][0-9]|30[1-9]|3[1-2][0-9])$/', $sector->nombre)) {
            for ($fila = 1; $fila <= 20; $fila++) {
                for ($numero = 1; $numero <= 15; $numero++) {
                    $asientos[] = Asiento::create([
                        'sector_id' => $sector->id,
                        'fila' => (string) $fila,
                        'numero' => $numero,
                    ]);
                }
            }
        } elseif (str_starts_with($sector->nombre, 'Palco')) {
            for ($numero = 1; $numero <= 8; $numero++) {
                $asientos[] = Asiento::create([
                    'sector_id' => $sector->id,
                    'fila' => 'A',
                    'numero' => $numero,
                ]);
            }
        } elseif ($sector->nombre === 'CLUB') {
            for ($fila = 1; $fila <= 10; $fila++) {
                for ($numero = 1; $numero <= 20; $numero++) {
                    $asientos[] = Asiento::create([
                        'sector_id' => $sector->id,
                        'fila' => (string) $fila,
                        'numero' => $numero,
                    ]);
                }
            }
        } elseif ($sector->nombre === 'JOHNNIE WALKER') {
            for ($fila = 1; $fila <= 8; $fila++) {
                for ($numero = 1; $numero <= 15; $numero++) {
                    $asientos[] = Asiento::create([
                        'sector_id' => $sector->id,
                        'fila' => (string) $fila,
                        'numero' => $numero,
                    ]);
                }
            }
        } elseif ($sector->nombre === 'PISTA') {
            for ($fila = 1; $fila <= 30; $fila++) {
                for ($numero = 1; $numero <= 25; $numero++) {
                    $asientos[] = Asiento::create([
                        'sector_id' => $sector->id,
                        'fila' => (string) $fila,
                        'numero' => $numero,
                    ]);
                }
            }
        } elseif ($sector->nombre === 'FRONT STAGE') {
            for ($fila = 1; $fila <= 5; $fila++) {
                for ($numero = 1; $numero <= 30; $numero++) {
                    $asientos[] = Asiento::create([
                        'sector_id' => $sector->id,
                        'fila' => (string) $fila,
                        'numero' => $numero,
                    ]);
                }
            }
        }

        return $asientos;
    }
}

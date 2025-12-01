<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        $agendamentos = [];

        for ($i = 1; $i <= 20; $i++) {
            $agendamentos[] = [
                'paciente_id' => rand(1, 10),
                'medico_id' => rand(1, 5),
                'data_consulta' => now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'status' => 'agendado',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('agendamentos')->insert($agendamentos);
    }
}

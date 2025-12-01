<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medicos')->insert([
            ['nome' => 'Dr. Marcos Andrade', 'especialidade' => 'Cardiologia', 'telefone' => '51988880001'],
            ['nome' => 'Dra. Paula Ribeiro', 'especialidade' => 'Pediatria', 'telefone' => '51988880002'],
            ['nome' => 'Dr. Vinícius Gomes', 'especialidade' => 'Ortopedia', 'telefone' => '51988880003'],
            ['nome' => 'Dra. Bianca Lima', 'especialidade' => 'Dermatologia', 'telefone' => '51988880004'],
            ['nome' => 'Dr. Arthur Silva', 'especialidade' => 'Neurologia', 'telefone' => '51988880005'],
        ]);
    }
}

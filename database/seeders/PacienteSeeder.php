<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pacientes')->insert([
            ['nome' => 'João Silva', 'email' => 'joao@example.com', 'telefone' => '51999990001', 'data_nascimento' => '1990-03-10'],
            ['nome' => 'Maria Oliveira', 'email' => 'maria@example.com', 'telefone' => '51999990002', 'data_nascimento' => '1988-08-21'],
            ['nome' => 'Carlos Ferreira', 'email' => 'carlos@example.com', 'telefone' => '51999990003', 'data_nascimento' => '1975-05-14'],
            ['nome' => 'Ana Costa', 'email' => 'ana@example.com', 'telefone' => '51999990004', 'data_nascimento' => '2000-09-30'],
            ['nome' => 'Lucas Pereira', 'email' => 'lucas@example.com', 'telefone' => '51999990005', 'data_nascimento' => '1995-12-12'],
            ['nome' => 'Juliana Santos', 'email' => 'juliana@example.com', 'telefone' => '51999990006', 'data_nascimento' => '1992-04-19'],
            ['nome' => 'Pedro Rocha', 'email' => 'pedro@example.com', 'telefone' => '51999990007', 'data_nascimento' => '1987-02-08'],
            ['nome' => 'Larissa Almeida', 'email' => 'larissa@example.com', 'telefone' => '51999990008', 'data_nascimento' => '1999-07-27'],
            ['nome' => 'Ricardo Duarte', 'email' => 'ricardo@example.com', 'telefone' => '51999990009', 'data_nascimento' => '1984-06-03'],
            ['nome' => 'Fernanda Melo', 'email' => 'fernanda@example.com', 'telefone' => '51999990010', 'data_nascimento' => '1993-11-15'],
        ]);
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\AgendamentoController;

/*
|--------------------------------------------------------------------------
| Rotas da API – Clínica Médica
|--------------------------------------------------------------------------
| Todas as rotas do sistema, incluindo CRUDs completos,
| filtros e relatórios básicos.
|--------------------------------------------------------------------------
*/

// ----------------------
// Pacientes
// ----------------------
Route::apiResource('pacientes', PacienteController::class);

// Buscar pacientes por nome
Route::get('pacientes/buscar/{nome}', [PacienteController::class, 'buscarPorNome']);



// ----------------------
// Médicos
// ----------------------
Route::apiResource('medicos', MedicoController::class);

// Buscar médicos por especialidade
Route::get('medicos/especialidade/{especialidade}', [MedicoController::class, 'buscarPorEspecialidade']);



// ----------------------
// Agendamentos
// ----------------------
Route::apiResource('agendamentos', AgendamentoController::class);

// Filtro por status (agendado, concluído, cancelado)
Route::get('agendamentos/status/{status}', [AgendamentoController::class, 'buscarPorStatus']);

// Filtro por dia
Route::get('agendamentos/data/{data}', [AgendamentoController::class, 'buscarPorData']);

// Relatório: agendamentos por médico
Route::get('relatorios/agendamentos/medico/{medico_id}', [AgendamentoController::class, 'agendamentosPorMedico']);

// Relatório: agendamentos por paciente
Route::get('relatorios/agendamentos/paciente/{paciente_id}', [AgendamentoController::class, 'agendamentosPorPaciente']);

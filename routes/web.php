<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AuthController;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Agendamento;

// Rotas de Autenticação (públicas)
Route::get('/', function () {
    if (session('authenticated')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas Protegidas (requerem autenticação)
Route::middleware(['check.auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'pacientes' => Paciente::count(),
            'medicos' => Medico::count(),
            'agendamentosHoje' => Agendamento::whereDate('data_consulta', today())->count(),
        ]);
    })->name('dashboard');

    // Rotas para Pacientes
    Route::resource('pacientes', PacienteController::class);

    // Rotas para Médicos
    Route::resource('medicos', MedicoController::class);

    // Rotas para Agendamentos
    Route::resource('agendamentos', AgendamentoController::class);
    Route::post('agendamentos/{id}/update-status', [AgendamentoController::class, 'updateStatus'])->name('agendamentos.updateStatus');

    // Rotas de busca adicionais (API)
    Route::get('/api/pacientes/buscar/{nome}', [PacienteController::class, 'buscarPorNome']);
    Route::get('/api/medicos/buscar/{especialidade}', [MedicoController::class, 'buscarPorEspecialidade']);
    Route::get('/api/agendamentos/status/{status}', [AgendamentoController::class, 'buscarPorStatus']);
    Route::get('/api/agendamentos/data/{data}', [AgendamentoController::class, 'buscarPorData']);
    Route::get('/api/agendamentos/medico/{medico_id}', [AgendamentoController::class, 'agendamentosPorMedico']);
    Route::get('/api/agendamentos/paciente/{paciente_id}', [AgendamentoController::class, 'agendamentosPorPaciente']);
    
});

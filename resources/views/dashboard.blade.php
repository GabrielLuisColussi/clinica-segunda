@extends('layout')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
    <p class="text-muted mb-0">Visão geral do sistema de clínica</p>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card p-4">
            <h5><i class="bi bi-people"></i> Total de Pacientes</h5>
            <h2>{{ $pacientes }}</h2>
            <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card p-4" style="border-left-color: #198754;">
            <h5><i class="bi bi-person-badge"></i> Total de Médicos</h5>
            <h2>{{ $medicos }}</h2>
            <a href="{{ route('medicos.index') }}" class="btn btn-sm btn-outline-success mt-2">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card p-4" style="border-left-color: #ffc107;">
            <h5><i class="bi bi-calendar-check"></i> Agendamentos Hoje</h5>
            <h2>{{ $agendamentosHoje }}</h2>
            <a href="{{ route('agendamentos.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Ações Rápidas -->
<div class="page-header mt-5">
    <h4><i class="bi bi-lightning"></i> Ações Rápidas</h4>
</div>

<div class="row">
    <div class="col-md-4">
        <a href="{{ route('agendamentos.create') }}" class="text-decoration-none">
            <div class="card p-4 text-center">
                <i class="bi bi-calendar-plus" style="font-size: 3rem; color: #0d6efd;"></i>
                <h5 class="mt-3">Novo Agendamento</h5>
                <p class="text-muted mb-0">Agendar nova consulta</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('pacientes.create') }}" class="text-decoration-none">
            <div class="card p-4 text-center">
                <i class="bi bi-person-plus" style="font-size: 3rem; color: #198754;"></i>
                <h5 class="mt-3">Novo Paciente</h5>
                <p class="text-muted mb-0">Cadastrar novo paciente</p>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('medicos.create') }}" class="text-decoration-none">
            <div class="card p-4 text-center">
                <i class="bi bi-person-badge-fill" style="font-size: 3rem; color: #6f42c1;"></i>
                <h5 class="mt-3">Novo Médico</h5>
                <p class="text-muted mb-0">Cadastrar novo médico</p>
            </div>
        </a>
    </div>
</div>
@endsection

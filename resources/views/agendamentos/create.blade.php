@extends('layout')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-calendar-plus"></i> Novo Agendamento</h2>
    <p class="text-muted mb-0">Preencha os dados para agendar uma nova consulta</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('agendamentos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Paciente *</label>
                        <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                            <option value="">Selecione um paciente...</option>
                            @foreach ($pacientes as $p)
                            <option value="{{ $p->id }}" {{ old('paciente_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nome }} - {{ $p->email }}
                            </option>
                            @endforeach
                        </select>
                        @error('paciente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person-badge"></i> Médico *</label>
                        <select name="medico_id" class="form-select @error('medico_id') is-invalid @enderror" required>
                            <option value="">Selecione um médico...</option>
                            @foreach ($medicos as $m)
                            <option value="{{ $m->id }}" {{ old('medico_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nome }} - {{ $m->especialidade }}
                            </option>
                            @endforeach
                        </select>
                        @error('medico_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-calendar3"></i> Data e Hora da Consulta *</label>
                        <input type="datetime-local" 
                               name="data_consulta" 
                               id="data_consulta"
                               class="form-control @error('data_consulta') is-invalid @enderror" 
                               value="{{ old('data_consulta') }}" 
                               min="{{ date('Y-m-d\TH:i') }}"
                               required>
                        @error('data_consulta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">A data e hora devem ser futuras</small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg"></i> Salvar Agendamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-info-circle"></i> Informações</h5>
                <hr>
                <p class="small text-muted mb-2">
                    <i class="bi bi-asterisk text-danger"></i> Campos marcados com * são obrigatórios
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-clock"></i> Certifique-se de verificar a disponibilidade do médico
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-bell"></i> O paciente será notificado sobre o agendamento
                </p>
            </div>
        </div>

        @if(count($pacientes) == 0 || count($medicos) == 0)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-danger"><i class="bi bi-exclamation-triangle"></i> Atenção</h5>
                <hr>
                @if(count($pacientes) == 0)
                <p class="small text-muted">
                    É necessário cadastrar pacientes antes de criar agendamentos.
                    <a href="{{ route('pacientes.create') }}">Cadastrar paciente</a>
                </p>
                @endif
                @if(count($medicos) == 0)
                <p class="small text-muted mb-0">
                    É necessário cadastrar médicos antes de criar agendamentos.
                    <a href="{{ route('medicos.create') }}">Cadastrar médico</a>
                </p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

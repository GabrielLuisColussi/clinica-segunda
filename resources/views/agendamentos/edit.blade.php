@extends('layout')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil"></i> Editar Agendamento</h2>
    <p class="text-muted mb-0">Atualize os dados do agendamento #{{ $agendamento->id }}</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Paciente *</label>
                        <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                            @foreach ($pacientes as $p)
                                <option value="{{ $p->id }}" 
                                    {{ old('paciente_id', $agendamento->paciente_id) == $p->id ? 'selected' : '' }}>
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
                            @foreach ($medicos as $m)
                                <option value="{{ $m->id }}"
                                    {{ old('medico_id', $agendamento->medico_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->nome }} - {{ $m->especialidade }}
                                </option>
                            @endforeach
                        </select>
                        @error('medico_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label"><i class="bi bi-calendar3"></i> Data e Hora da Consulta *</label>
                            <input type="datetime-local" 
                                  name="data_consulta" 
                                  class="form-control @error('data_consulta') is-invalid @enderror"
                                  value="{{ old('data_consulta', \Carbon\Carbon::parse($agendamento->data_consulta)->format('Y-m-d\TH:i')) }}"
                                  required>
                            @error('data_consulta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-info-circle"></i> Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="agendado" {{ old('status', $agendamento->status) == 'agendado' ? 'selected' : '' }}>
                                    Agendado
                                </option>
                                <option value="concluido" {{ old('status', $agendamento->status) == 'concluido' ? 'selected' : '' }}>
                                    Concluído
                                </option>
                                <option value="cancelado" {{ old('status', $agendamento->status) == 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Atualizar Agendamento
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
                    <strong>ID do Agendamento:</strong> #{{ $agendamento->id }}
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-asterisk text-danger"></i> Campos marcados com * são obrigatórios
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-bell"></i> Alterações serão notificadas ao paciente
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h5><i class="bi bi-clock-history"></i> Histórico</h5>
                <hr>
                <p class="small text-muted mb-2">
                    <strong>Status Atual:</strong> 
                    @if($agendamento->status == 'agendado')
                        <span class="badge bg-primary">Agendado</span>
                    @elseif($agendamento->status == 'concluido')
                        <span class="badge bg-success">Concluído</span>
                    @else
                        <span class="badge bg-danger">Cancelado</span>
                    @endif
                </p>
                <p class="small text-muted mb-0">
                    <strong>Data da Consulta:</strong><br>
                    {{ \Carbon\Carbon::parse($agendamento->data_consulta)->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

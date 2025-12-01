@extends('layout')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil"></i> Editar Paciente</h2>
    <p class="text-muted mb-0">Atualize os dados do paciente <strong>{{ $paciente->nome }}</strong></p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Nome Completo *</label>
                        <input type="text" name="nome" value="{{ old('nome', $paciente->nome) }}" class="form-control @error('nome') is-invalid @enderror" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Email *</label>
                            <input type="email" name="email" value="{{ old('email', $paciente->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-telephone"></i> Telefone *</label>
                            <input type="text" name="telefone" value="{{ old('telefone', $paciente->telefone) }}" class="form-control @error('telefone') is-invalid @enderror" placeholder="(00) 00000-0000" required>
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-calendar"></i> Data de Nascimento</label>
                        <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $paciente->data_nascimento) }}" class="form-control @error('data_nascimento') is-invalid @enderror" max="{{ date('Y-m-d', strtotime('-1 day')) }}">
                        @error('data_nascimento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">A data deve ser anterior a hoje</small>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Atualizar Paciente
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
                    <strong>ID do Paciente:</strong> #{{ $paciente->id }}
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-asterisk text-danger"></i> Campos marcados com * são obrigatórios
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-shield-check"></i> Os dados são protegidos pela LGPD
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

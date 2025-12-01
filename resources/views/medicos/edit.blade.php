@extends('layout')

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil"></i> Editar Médico</h2>
    <p class="text-muted mb-0">Atualize os dados do médico <strong>{{ $medico->nome }}</strong></p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('medicos.update', $medico->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Nome Completo *</label>
                        <input type="text" name="nome" value="{{ old('nome', $medico->nome) }}" class="form-control @error('nome') is-invalid @enderror" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-clipboard-pulse"></i> Especialidade *</label>
                            <input type="text" name="especialidade" value="{{ old('especialidade', $medico->especialidade) }}" class="form-control @error('especialidade') is-invalid @enderror" placeholder="Ex: Cardiologia, Pediatria..." required>
                            @error('especialidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-telephone"></i> Telefone *</label>
                            <input type="text" name="telefone" value="{{ old('telefone', $medico->telefone) }}" class="form-control @error('telefone') is-invalid @enderror" placeholder="(00) 00000-0000" required>
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('medicos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Atualizar Médico
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
                    <strong>ID do Médico:</strong> #{{ $medico->id }}
                </p>
                <p class="small text-muted mb-2">
                    <i class="bi bi-asterisk text-danger"></i> Campos marcados com * são obrigatórios
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-shield-check"></i> Os dados são protegidos e confidenciais
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

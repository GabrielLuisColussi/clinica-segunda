@extends('layout')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-person-badge"></i> Médicos</h2>
        <p class="text-muted mb-0">Gerenciamento de médicos cadastrados</p>
    </div>
    <a href="{{ route('medicos.create') }}" class="btn btn-success">
        <i class="bi bi-person-badge-fill"></i> Novo Médico
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nome</th>
                        <th>Especialidade</th>
                        <th>Telefone</th>
                        <th style="width: 200px;" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicos as $m)
                    <tr>
                        <td><span class="badge bg-secondary">#{{ $m->id }}</span></td>
                        <td><strong>{{ $m->nome }}</strong></td>
                        <td><span class="badge bg-primary">{{ $m->especialidade }}</span></td>
                        <td><i class="bi bi-telephone"></i> {{ $m->telefone }}</td>
                        <td class="text-center">
                            <a href="{{ route('medicos.edit', $m->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('medicos.destroy', $m->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este médico?')" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mb-0 mt-2">Nenhum médico cadastrado</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layout')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-calendar-check"></i> Agendamentos</h2>
        <p class="text-muted mb-0">Gerenciamento de consultas agendadas</p>
    </div>
    <a href="{{ route('agendamentos.create') }}" class="btn btn-success">
        <i class="bi bi-calendar-plus"></i> Novo Agendamento
    </a>
</div>

<!-- Alertas de Agendamentos Pendentes -->
@if(isset($agendamentosPendentes) && $agendamentosPendentes->count() > 0)
<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Agendamentos Pendentes</h5>
    <p class="mb-2">Existem <strong>{{ $agendamentosPendentes->count() }}</strong> agendamento(s) anterior(es) que ainda não foram marcados como concluídos ou cancelados:</p>
    
    <div class="list-group mt-3">
        @foreach($agendamentosPendentes as $pendente)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong><i class="bi bi-person"></i> {{ $pendente->paciente->nome }}</strong>
                <br>
                <small class="text-muted">
                    <i class="bi bi-person-badge"></i> Dr(a). {{ $pendente->medico->nome }} | 
                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($pendente->data_consulta)->format('d/m/Y H:i') }}
                </small>
            </div>
            <div class="btn-group" role="group">
                <form action="{{ route('agendamentos.updateStatus', $pendente->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <input type="hidden" name="status" value="concluido">
                    <button type="submit" class="btn btn-success btn-sm" title="Marcar como Concluído">
                        <i class="bi bi-check-circle"></i> Concluído
                    </button>
                </form>
                <form action="{{ route('agendamentos.updateStatus', $pendente->id) }}" method="POST" style="display: inline-block;" class="ms-2">
                    @csrf
                    <input type="hidden" name="status" value="cancelado">
                    <button type="submit" class="btn btn-danger btn-sm" title="Marcar como Cancelado">
                        <i class="bi bi-x-circle"></i> Cancelado
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Data Consulta</th>
                        <th style="width: 150px;">Status</th>
                        <th style="width: 200px;" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendamentos as $a)
                    <tr>
                        <td><span class="badge bg-secondary">#{{ $a->id }}</span></td>
                        <td><i class="bi bi-person"></i> <strong>{{ $a->paciente->nome }}</strong></td>
                        <td><i class="bi bi-person-badge"></i> {{ $a->medico->nome }}</td>
                        <td>
                            <i class="bi bi-calendar3"></i> 
                            {{ \Carbon\Carbon::parse($a->data_consulta)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            @if($a->status == 'agendado')
                                <span class="badge bg-primary">Agendado</span>
                            @elseif($a->status == 'concluido')
                                <span class="badge bg-success">Concluído</span>
                            @elseif($a->status == 'cancelado')
                                <span class="badge bg-danger">Cancelado</span>
                            @else
                                <span class="badge bg-secondary">{{ $a->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('agendamentos.edit', $a->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('agendamentos.destroy', $a->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mb-0 mt-2">Nenhum agendamento cadastrado</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

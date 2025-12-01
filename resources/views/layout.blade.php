<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #fff;
            box-shadow: 2px 0 4px rgba(0,0,0,.08);
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 8px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .content-area {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
        }
        .table {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .btn {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
        }
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        .page-header h2 {
            color: #212529;
            font-weight: 600;
        }
        .stat-card {
            border-left: 4px solid #0d6efd;
        }
        .stat-card h5 {
            color: #6c757d;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card h2 {
            color: #212529;
            font-weight: 700;
            margin-top: 10px;
        }
        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .notification-item {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            transition: background 0.2s;
        }
        .notification-item:hover {
            background: #f8f9fa;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-dropdown {
            min-width: 350px;
            max-height: 400px;
            overflow-y: auto;
        }
        .notification-empty {
            padding: 20px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <i class="bi bi-hospital"></i> Sistema Clínica
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            @php
                                $agora = \Carbon\Carbon::now();
                                $agendamentosPendentes = \App\Models\Agendamento::where('status', 'agendado')
                                    ->where(function($query) use ($agora) {
                                        // Consultas de dias anteriores
                                        $query->whereDate('data_consulta', '<', $agora->toDateString())
                                        // OU consultas do dia atual com horário já passado
                                        ->orWhere(function($q) use ($agora) {
                                            $q->whereDate('data_consulta', $agora->toDateString())
                                              ->whereTime('data_consulta', '<=', $agora->toTimeString());
                                        });
                                    })
                                    ->count();
                            @endphp
                            @if($agendamentosPendentes > 0)
                                <span class="notification-badge">{{ $agendamentosPendentes }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-bell-fill"></i> Notificações
                                    @if($agendamentosPendentes > 0)
                                        <span class="badge bg-danger ms-2">{{ $agendamentosPendentes }}</span>
                                    @endif
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if($agendamentosPendentes > 0)
                                @php
                                    $agora = \Carbon\Carbon::now();
                                    $pendentes = \App\Models\Agendamento::with(['paciente', 'medico'])
                                        ->where('status', 'agendado')
                                        ->where(function($query) use ($agora) {
                                            // Consultas de dias anteriores
                                            $query->whereDate('data_consulta', '<', $agora->toDateString())
                                            // OU consultas do dia atual com horário já passado
                                            ->orWhere(function($q) use ($agora) {
                                                $q->whereDate('data_consulta', $agora->toDateString())
                                                  ->whereTime('data_consulta', '<=', $agora->toTimeString());
                                            });
                                        })
                                        ->orderBy('data_consulta', 'desc')
                                        ->limit(10)
                                        ->get();
                                @endphp
                                @foreach($pendentes as $pendente)
                                <li>
                                    <div class="notification-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <strong><i class="bi bi-exclamation-triangle text-warning"></i> Consulta Pendente</strong>
                                                <p class="mb-1 small">
                                                    <i class="bi bi-person"></i> <strong>{{ $pendente->paciente->nome }}</strong><br>
                                                    <i class="bi bi-person-badge"></i> Dr(a). {{ $pendente->medico->nome }}<br>
                                                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($pendente->data_consulta)->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('agendamentos.index') }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Atualizar
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="notification-empty">
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">Nenhuma notificação</p>
                                        <small>Todas as consultas estão atualizadas!</small>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ session('usuario', 'Usuário') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <nav class="nav flex-column p-3">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('pacientes*') ? 'active' : '' }}" href="{{ route('pacientes.index') }}">
                        <i class="bi bi-people"></i> Pacientes
                    </a>
                    <a class="nav-link {{ request()->is('medicos*') ? 'active' : '' }}" href="{{ route('medicos.index') }}">
                        <i class="bi bi-person-badge"></i> Médicos
                    </a>
                    <a class="nav-link {{ request()->is('agendamentos*') ? 'active' : '' }}" href="{{ route('agendamentos.index') }}">
                        <i class="bi bi-calendar-check"></i> Agendamentos
                    </a>
                    <hr>
                    <form action="{{ route('logout') }}" method="POST" class="px-3 mb-2">
                        @csrf
                        <button type="submit" class="nav-link text-danger w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="content-area">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            border: 1px solid #e0e0e0;
            overflow: hidden;
            max-width: 400px;
            width: 90%;
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 20px;
            text-align: center;
            color: white;
        }
        .login-header i {
            font-size: 3rem;
            margin-bottom: 8px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .login-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
        }
        .login-header p {
            margin: 3px 0 0 0;
            opacity: 0.9;
            font-size: 13px;
        }
        .login-body {
            padding: 25px 25px 20px 25px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
            padding: 10px 12px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-hint {
            background: #ffc107;
            border: none;
            color: #000;
            padding: 8px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 15px;
        }
        .btn-hint:hover {
            background: #ffb300;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        .btn-hint i {
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.5; }
        }
        .credentials-hint {
            background: #fff3cd;
            border: 2px dashed #ffc107;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            display: none;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .credentials-hint.show {
            display: block;
        }
        .credentials-hint p {
            margin: 4px 0;
            font-weight: 600;
            font-size: 13px;
            color: #856404;
        }
        .credentials-hint i {
            color: #ffc107;
        }
        .alert {
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .form-label {
            font-size: 14px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="bi bi-hospital"></i>
            <h3>Sistema de Clínica</h3>
            <p>Faça login para continuar</p>
        </div>
        
        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Botão da Lâmpada -->
            <button type="button" class="btn btn-hint" onclick="toggleHint()">
                <i class="bi bi-lightbulb-fill"></i> Não sabe as credenciais? Clique aqui!
            </button>

            <!-- Dica de Credenciais -->
            <div class="credentials-hint" id="credentialsHint">
                <p><i class="bi bi-info-circle-fill"></i> <strong>Credenciais de Acesso:</strong></p>
                <p><i class="bi bi-person-fill"></i> <strong>Usuário:</strong> admin</p>
                <p><i class="bi bi-key-fill"></i> <strong>Senha:</strong> 1234</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label class="form-label fw-bold">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input 
                            type="text" 
                            name="usuario" 
                            class="form-control @error('usuario') is-invalid @enderror" 
                            placeholder="Digite o usuário"
                            value="{{ old('usuario') }}"
                            required
                            autofocus>
                    </div>
                    @error('usuario')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            name="senha" 
                            id="senha"
                            class="form-control @error('senha') is-invalid @enderror" 
                            placeholder="Digite a senha"
                            required>
                        <button 
                            class="btn btn-outline-secondary" 
                            type="button" 
                            onclick="togglePassword()"
                            style="border-radius: 0 10px 10px 0; border-left: none;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('senha')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar no Sistema
                </button>
            </form>

            <div class="text-center mt-2">
                <small class="text-muted" style="font-size: 12px;">
                    <i class="bi bi-shield-check"></i> Sistema seguro e protegido
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleHint() {
            const hint = document.getElementById('credentialsHint');
            hint.classList.toggle('show');
        }

        function togglePassword() {
            const senhaInput = document.getElementById('senha');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                senhaInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>


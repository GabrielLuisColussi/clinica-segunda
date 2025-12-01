<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Exibe a tela de login
     */
    public function showLogin()
    {
        // Se já estiver logado, redireciona para o dashboard
        if (session('authenticated')) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'usuario' => 'required',
            'senha' => 'required',
        ], [
            'usuario.required' => 'O campo usuário é obrigatório.',
            'senha.required' => 'O campo senha é obrigatório.',
        ]);

        // Credenciais fixas
        $usuarioCorreto = 'admin';
        $senhaCorreta = '1234';

        // Verifica as credenciais
        if ($request->usuario === $usuarioCorreto && $request->senha === $senhaCorreta) {
            // Login bem-sucedido - cria sessão
            session([
                'authenticated' => true,
                'usuario' => $request->usuario,
                'login_time' => now()
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Login realizado com sucesso! Bem-vindo(a) ' . $request->usuario . '!');
        }

        // Login falhou
        return back()
            ->withInput($request->only('usuario'))
            ->with('error', 'Usuário ou senha incorretos. Tente novamente.');
    }

    /**
     * Realiza o logout
     */
    public function logout()
    {
        // Remove dados da sessão
        session()->forget(['authenticated', 'usuario', 'login_time']);
        session()->flush();

        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }
}


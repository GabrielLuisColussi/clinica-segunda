<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:pacientes|max:255',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'nullable|date|before:today'
        ], [
            'data_nascimento.before' => 'A data de nascimento deve ser anterior ao dia de hoje.',
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.'
        ]);

        Paciente::create($data);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paciente = Paciente::with('agendamentos')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $paciente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:pacientes,email,' . $id . '|max:255',
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'nullable|date|before:today'
        ], [
            'data_nascimento.before' => 'A data de nascimento deve ser anterior ao dia de hoje.',
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.'
        ]);

        $paciente->update($data);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Paciente::findOrFail($id)->delete();

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente removido com sucesso!');
    }

    public function buscarPorNome($nome)
    {
        $pacientes = Paciente::where('nome', 'LIKE', "%{$nome}%")->get();

        return response()->json([
            'success' => true,
            'data' => $pacientes
        ]);
    }
}

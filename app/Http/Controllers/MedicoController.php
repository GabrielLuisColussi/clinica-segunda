<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = Medico::all();
        return view('medicos.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'telefone' => 'required|string|max:20'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'especialidade.required' => 'A especialidade é obrigatória.',
            'telefone.required' => 'O telefone é obrigatório.'
        ]);

        Medico::create($data);

        return redirect()->route('medicos.index')
            ->with('success', 'Médico criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medico = Medico::with('agendamentos')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $medico
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        return view('medicos.edit', compact('medico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $medico = Medico::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'especialidade' => 'required|string|max:255',
            'telefone' => 'required|string|max:20'
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'especialidade.required' => 'A especialidade é obrigatória.',
            'telefone.required' => 'O telefone é obrigatório.'
        ]);

        $medico->update($data);

        return redirect()->route('medicos.index')
            ->with('success', 'Médico atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Medico::findOrFail($id)->delete();

        return redirect()->route('medicos.index')
            ->with('success', 'Médico removido com sucesso!');
    }

    public function buscarPorEspecialidade($especialidade)
    {
        $medicos = Medico::where('especialidade', 'LIKE', "%{$especialidade}%")->get();

        return response()->json([
            'success' => true,
            'data' => $medicos
        ]);
    }
}

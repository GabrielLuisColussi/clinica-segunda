<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAgendamentoRequest;
use App\Http\Requests\UpdateAgendamentoRequest;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendamentos = Agendamento::with(['paciente', 'medico'])->orderBy('data_consulta', 'desc')->get();
        
        // Buscar agendamentos pendentes: dias anteriores OU dia atual com horário já passado
        $agora = Carbon::now();
        $agendamentosPendentes = Agendamento::with(['paciente', 'medico'])
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
            ->get();
        
        return view('agendamentos.index', compact('agendamentos', 'agendamentosPendentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = \App\Models\Paciente::all();
        $medicos   = \App\Models\Medico::all();

        return view('agendamentos.create', compact('pacientes', 'medicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgendamentoRequest $request)
    {
        $data = $request->validated();

        // Define status padrão como 'agendado' se não for fornecido
        if (!isset($data['status'])) {
            $data['status'] = 'agendado';
        }

        Agendamento::create($data);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $agendamento = Agendamento::with(['paciente', 'medico'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $agendamento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $pacientes = \App\Models\Paciente::all();
        $medicos   = \App\Models\Medico::all();

        return view('agendamentos.edit', compact('agendamento', 'pacientes', 'medicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgendamentoRequest $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $data = $request->validated();
        $agendamento->update($data);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Atualizar status de um agendamento rapidamente
     */
    public function updateStatus(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:concluido,cancelado'
        ]);
        
        $agendamento->update(['status' => $request->status]);
        
        $statusTexto = $request->status === 'concluido' ? 'concluído' : 'cancelado';
        
        return redirect()->route('agendamentos.index')
            ->with('success', "Agendamento marcado como {$statusTexto}!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Agendamento::findOrFail($id)->delete();

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento removido com sucesso!');
    }

    public function buscarPorStatus($status)
    {
        $agendamentos = Agendamento::with(['paciente', 'medico'])
            ->where('status', $status)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agendamentos
        ]);
    }

    public function buscarPorData($data)
    {
        $agendamentos = Agendamento::with(['paciente', 'medico'])
            ->whereDate('data_consulta', $data)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agendamentos
        ]);
    }

    public function agendamentosPorMedico($medico_id)
    {
        $agendamentos = Agendamento::with(['paciente', 'medico'])
            ->where('medico_id', $medico_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agendamentos
        ]);
    }

    public function agendamentosPorPaciente($paciente_id)
    {
        $agendamentos = Agendamento::with(['paciente', 'medico'])
            ->where('paciente_id', $paciente_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $agendamentos
        ]);
    }


}

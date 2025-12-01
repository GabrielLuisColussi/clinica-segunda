<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreAgendamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'data_consulta' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dataConsulta = Carbon::parse($value);
                    $agora = Carbon::now();

                    // Verifica se a data da consulta é no passado
                    if ($dataConsulta->lt($agora)) {
                        $fail('A data e hora da consulta não podem ser no passado.');
                    }
                },
            ],
            'status' => 'nullable|string|in:agendado,concluido,cancelado'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'paciente_id.required' => 'Selecione um paciente.',
            'paciente_id.exists' => 'O paciente selecionado não existe.',
            'medico_id.required' => 'Selecione um médico.',
            'medico_id.exists' => 'O médico selecionado não existe.',
            'data_consulta.required' => 'A data e hora da consulta são obrigatórias.',
            'data_consulta.date' => 'A data da consulta deve ser válida.',
            'status.in' => 'O status deve ser: agendado, concluído ou cancelado.',
        ];
    }
}


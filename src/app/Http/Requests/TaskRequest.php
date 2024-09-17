<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pendente,Em Andamento,Concluída',
            'priority' => 'required|in:Baixa,Média,Alta',
            'deadline' => 'nullable|date|after_or_equal:today',
        ];
    }
}

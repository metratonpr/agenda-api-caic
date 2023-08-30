<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTarefaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data' => 'required | date', 
            'assunto' => 'required | min:2 | max: 50', 
            'descricao' => 'required | min: 2 | max: 240' , 
            'contato' => 'required | min: 2 | max: 50', 
            'tipo_id' =>'required | exists:tipos,id'
        ];
    }
}

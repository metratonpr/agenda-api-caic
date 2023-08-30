<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
    
    protected $fillable = ['data', 'assunto', 'descricao', 'contato', 'tipo_id'];

    public function tipo()
    {
       return $this->belongsTo(Tipo::class, 'tipo_id');
    }
}

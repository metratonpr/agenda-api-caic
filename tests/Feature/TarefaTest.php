<?php

namespace Tests\Feature;

use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TarefaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A função index deve retornar 5 cadastros
     *
     * @return void
     */
    public function test_funcao_index_retornar_array_com_sucesso()
    {
        //Criar parametros
        $tarefas = Tarefa::factory()->count(5)->create();     
        
        //Usar verbo GET
        $response = $this->getJson('/api/tipos/');
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => ['id', 'data', 'assunto', 'descricao', 
                        'contato', 'tipo_id', 'created_at', 'updated_at']
                    ]
                ]
            );
    }
}

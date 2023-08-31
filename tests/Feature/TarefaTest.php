<?php

namespace Tests\Feature;

use App\Models\Tarefa;
use App\Models\Tipo;
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
        $response = $this->getJson('/api/tarefas/');
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id', 'data', 'assunto', 'descricao',
                            'contato', 'tipo_id', 'created_at', 'updated_at'
                        ]
                    ]
                ]
            );
    }


    /**
     * Deve cadastrar um novo registro com sucesso
     * @return void
     */
    public function test_criar_um_novo_tarefa_com_sucesso()
    {
        //Criar Tipo
        $tipo = Tipo::factory()->create();
        //Criar dados
        $data = [
            'data' => $this->faker->date(),
            'assunto' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'contato' => $this->faker->name(),
            'tipo_id' => $tipo->id
        ];
        //Processar
        $response = $this->postJson('/api/tarefas/', $data);
        //Avaliar a saida
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'data', 'assunto', 'descricao',
                'contato', 'tipo_id', 'created_at', 'updated_at'
            ]);
    }

    /**
     * Deve cadastrar um novo registro com falha
     * @return void
     */
    public function test_criar_um_novo_tarefa_com_falha()
    {
        //Criar dados
        $data = [
            'data' => "",
            'assunto' => "",
            'descricao' => "",
            'contato' => "",
            'tipo_id' => 99999999999999999
        ];
        //Processar
        $response = $this->postJson('/api/tarefas/', $data);
        //Avaliar a saida
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'data', 'assunto', 'descricao',
                'contato', 'tipo_id'
            ]);
    }

    /**
     * Buscar um id no servidor com sucesso!
     * @return void
     */
    public function test_buscar_id_no_banco_com_sucesso()
    {
        //Criar dados
        $tarefa = Tarefa::factory()->create();
        //processar
        $response = $this->getJson('/api/tarefas/' . $tarefa->id);
        //verificar saida
        $response->assertStatus(200)
            ->assertJson([
                'id' => $tarefa->id,
                'data' => $tarefa->data,
                'assunto' => $tarefa->assunto,
                'descricao' => $tarefa->descricao,
                'contato' => $tarefa->contato,
                'tipo_id' => $tarefa->tipo_id
            ]);
    }
    /**
     * Deve dar erro ao tentar pesquisar um cadastro inexistente
     * @return void
     */
    public function test_buscar_id_no_banco_com_falha()
    {
        //processar
        $response = $this->getJson('/api/tarefas/99999999');
        //verificar saida
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tarefa não encontrado!"
            ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Tipo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A função index deve retornar 5 cadastros
     *
     * @return void
     */
    public function test_funcao_index_retornar_array_com_sucesso()
    {
        //$tipo = Tipo::factory()->create();

        //Criar parametros
        Tipo::factory()->count(5)->create();
        //Processar
        //Fazer uma chamada para a rota index no api
        //Usar verbo GET
        $response = $this->getJson('/api/tipos/');
        // dd($response['data']);
        //Verificar resposta
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => ['id', 'descricao', 'created_at', 'updated_at']
                    ]
                ]
            );
    }

    /**
     * Deve cadastrar um novo registro com sucesso
     * @return void
     */
    public function test_criar_um_novo_tipo_com_sucesso()
    {
        //Criar dados
        $data = [
            'descricao' => "Cancelado"
        ];
        //Processar
        $response = $this->postJson('/api/tipos/', $data);
        //Avaliar a saida
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'descricao', 'created_at',
                'updated_at'
            ]);
    }

    /**
     * Deve cadastrar um novo registro com falha
     * @return void
     */
    public function test_criar_um_novo_tipo_com_falha()
    {
        //Criar dados
        $data = [
            'descricao' => ""
        ];
        //Processar
        $response = $this->postJson('/api/tipos/', $data);
        //Avaliar a saida
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }
    /**
     * Buscar um id no servidor com sucesso!
     * @return void
     */
    public function test_buscar_id_no_banco_com_sucesso()
    {
        //Criar dados
        $tipo = Tipo::factory()->create();
        //processar
        $response = $this->getJson('/api/tipos/' . $tipo->id);
        //verificar saida
        $response->assertStatus(200)
            ->assertJson([
                'id' => $tipo->id,
                'descricao' => $tipo->descricao,
            ]);
    }
    /**
     * Deve dar erro ao tentar pesquisar um cadastro inexistente
     * @return void
     */
    public function test_buscar_id_no_banco_com_falha()
    {
        //processar
        $response = $this->getJson('/api/tipos/99999999');
        //verificar saida
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado!"
            ]);
    }

    /**
     * Teste de atualizacao com sucesso
     * @return void
     */

    public function test_atualizar_tipo_com_sucesso()
    {
        //Criar dados
        $tipo = Tipo::factory()->create();
        $new = [
            'descricao' => 'Nova descrição'
        ];
        //Processar
        $response = $this->putJson('/api/tipos/' . $tipo->id, $new);
        //Analisar
        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $tipo->id,
                'descricao' => 'Nova descrição',
            ]);
    }

    /**
     * Teste de atualizacao com falha de tipo inexistente
     * @return void
     */

    public function test_atualizar_tipo_inexistente_com_falha()
    {
        //Criar dados
        $new = [
            'descricao' => 'Nova descrição'
        ];
        //Processar
        $response = $this->putJson('/api/tipos/999999', $new);
        //Analisar
        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado!"
            ]);
    }

    /**
     * Teste de atualizacao com falha nos dados
     * @return void
     */
    public function test_atualizar_tipo_com_falha_nos_dados()
    {
        //Criar dados
        $tipo = Tipo::factory()->create();
        $new = [
            'descricao' => ''
        ];
        //Processar
        $response = $this->putJson('/api/tipos/' . $tipo->id, $new);
        //Analisar
        // Verifique a resposta
        //Avaliar a saida
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }

    /**
     * Teste de atualizacao com falha na descricao unica
     * @return void
     */
    public function test_atualizar_tipo_com_falha_na_descricao_unica()
    {
        //Criar dados
        $tipo = Tipo::factory()->create();
        $updated = Tipo::factory()->create();
        // Para para upgrade
        $new = ['descricao' => $tipo->descricao,];
        //Processar
        $response = $this->putJson('/api/tipos/' . $updated->id, $new);
        //Avaliar a saida
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }


    /**
     * Deve deletar com sucesso um registro do banco
     */
    public function test_deletar_tipo_com_sucesso(){
        //Criar o tipo
        $tipo = Tipo::factory()->create();

        //Processar
        $response = $this->deleteJson('/api/tipos/'.$tipo->id);
        //Analisar
        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'message' => "Tipo deletado com sucesso!"
            ]);
    }

    /**
     * Deve dar erro ao deletar um registro inexistente
     */
    public function test_deletar_tipo_com_falha(){

        //Processar
        $response = $this->deleteJson('/api/tipos/999999');
        //Analisar
        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => "Tipo não encontrado!"
            ]);
    }
}

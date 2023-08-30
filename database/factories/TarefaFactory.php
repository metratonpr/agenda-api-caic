<?php

namespace Database\Factories;

use App\Models\Tipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarefa>
 */
class TarefaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'data' => $this->faker->date(),
            'assunto' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'contato' => $this->faker->name(),
            'tipo_id' => function () {
                return Tipo::factory()->create()->id;
            }
        ];
    }
}

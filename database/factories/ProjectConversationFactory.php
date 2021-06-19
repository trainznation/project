<?php

namespace Database\Factories;

use App\Models\ProjectConversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectConversation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "message" => $this->faker->sentence(rand(5,25)),
        ];
    }
}

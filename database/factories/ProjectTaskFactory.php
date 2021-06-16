<?php

namespace Database\Factories;

use App\Models\ProjectTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(rand(2, 6), true),
            "description" => $this->faker->paragraph(rand(1,2)),
            "state" => rand(0,1),
            "priority" => rand(0,2)
        ];
    }
}

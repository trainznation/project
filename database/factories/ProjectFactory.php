<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(80),
            "short_description" => $this->faker->realText(rand(50,254)),
            "description" => $this->faker->paragraph(5, true),
            "published" => rand(0,2),
            "state" => rand(0,3)
        ];
    }
}

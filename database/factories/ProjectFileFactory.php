<?php

namespace Database\Factories;

use App\Models\ProjectFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(rand(10,50));
        return [
            "type" => array_rand(arrayTypeFile(), 1),
            "name" => $name
        ];
    }
}

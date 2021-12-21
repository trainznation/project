<?php

namespace Database\Seeders;

use App\Models\ProjectTaskCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestingBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env("APP_ENV") == 'test') {
            User::create([
                "name" => "Utilisateur Test",
                "email" => "test@example.com",
                "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi" //password
            ]);

            ProjectTaskCategory::create(["name" => "Documentations"]);
            ProjectTaskCategory::create(["name" => "3D"]);
            ProjectTaskCategory::create(["name" => "UV"]);
            ProjectTaskCategory::create(["name" => "Texture"]);
            ProjectTaskCategory::create(["name" => "Script"]);
            ProjectTaskCategory::create(["name" => "Finalisation"]);
            ProjectTaskCategory::create(["name" => "Communication"]);
        }
    }
}

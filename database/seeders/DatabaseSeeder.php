<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectTask;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');
        if (env("APP_ENV") == 'local') {
            \App\Models\User::factory(10)->create();
            User::create([
                "name" => "Utilisateur Test",
                "email" => "test@example.com",
                "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
            ]);
            $users = User::all();

            Project::factory(rand(10, 90))->create();

            $projects = Project::all();
            foreach ($projects as $project) {
                for ($i = 1; $i < rand(1, 10); $i++) {
                    DB::table('project_user')->insert([
                        "user_id" => $i,
                        "project_id" => $project->id
                    ]);
                }

                for ($k = 1; $k < rand(1, $projects->count()); $k++) {
                    ProjectTask::factory()->create([
                        "project_id" => $k,
                        "created_at" => now()->subDays(rand(5,430)),
                        "updated_at" => now()->subDays(rand(5,430))
                    ]);
                }

                for($l = 1; $l < rand(1, $projects->count()); $l++) {
                    $name = "Test File ".$l;
                    $type = Arr::random(arrayTypeFile(), 1);
                    ProjectFile::factory()->create([
                        "name" => $name,
                        "type" => $type[0],
                        "project_id" => $l,
                        "uri" => "/storage/files/projects/".$l."/".Str::slug($name).".".$type[0],
                        "size" => rand(900,15000000),
                        "user_id" => rand(1, $users->count())
                    ]);
                }
            }
        }
    }
}

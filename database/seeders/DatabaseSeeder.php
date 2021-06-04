<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env("APP_ENV") == 'local') {
            \App\Models\User::factory(10)->create();
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
                        "project_id" => $k
                    ]);
                }
            }
        }
    }
}

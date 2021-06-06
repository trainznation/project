<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @var Project
     */
    private $project;

    /**
     * ProjectController constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function graphData($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        return response()->json([
            "overview" => [$project->tasks()->where('state',0)->count(), $project->tasks()->where('state',1)->count()],
            "metric" => [
                "open" => [
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-01-01 00:00:00', '2021-01-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-02-01 00:00:00', '2021-02-27 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-03-01 00:00:00', '2021-03-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-04-01 00:00:00', '2021-04-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-05-01 00:00:00', '2021-05-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-06-01 00:00:00', '2021-06-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-07-01 00:00:00', '2021-07-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-08-01 00:00:00', '2021-08-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-09-01 00:00:00', '2021-09-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-10-01 00:00:00', '2021-10-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-11-01 00:00:00', '2021-11-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 0)->whereBetween('created_at', ['2021-12-01 00:00:00', '2021-12-31 00:00:00'])->count(),
                ],
                "close" => [
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-01-01 00:00:00', '2021-01-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-02-01 00:00:00', '2021-02-27 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-03-01 00:00:00', '2021-03-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-04-01 00:00:00', '2021-04-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-05-01 00:00:00', '2021-05-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-06-01 00:00:00', '2021-06-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-07-01 00:00:00', '2021-07-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-08-01 00:00:00', '2021-08-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-09-01 00:00:00', '2021-09-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-10-01 00:00:00', '2021-10-31 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-11-01 00:00:00', '2021-11-30 00:00:00'])->count(),
                    $project->tasks()->where('state', 1)->whereBetween('created_at', ['2021-12-01 00:00:00', '2021-12-31 00:00:00'])->count(),
                ]
            ]
        ]);
    }
}

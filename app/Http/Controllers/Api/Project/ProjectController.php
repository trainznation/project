<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectTask;
use App\Models\User;
use App\Notifications\Project\DeleteTaskNotification;
use App\Notifications\Project\EditTaskNotification;
use App\Notifications\Project\StateTaskNotification;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @var Project
     */
    private $project;
    /**
     * @var ProjectTask
     */
    private $projectTask;

    /**
     * ProjectController constructor.
     * @param Project $project
     * @param ProjectTask $projectTask
     */
    public function __construct(Project $project, ProjectTask $projectTask)
    {
        $this->project = $project;
        $this->projectTask = $projectTask;
    }

    public function graphData($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        return response()->json([
            "overview" => [$project->tasks()->where('state', 0)->count(), $project->tasks()->where('state', 1)->count()],
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

    public function getTask($project_id, $task_id)
    {
        $task = $this->projectTask->newQuery()->find($task_id);

        $arr = [
            "id" => $task->id,
            "title" => $task->title,
            "description" => $task->description,
            "category" => [
                "name" => $task->category->name,
                "id" => $task->category->id
            ]
        ];

        return response()->json($arr);
    }

    public function updateTask(Request $request, $project_id, $task_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $task = $this->projectTask->newQuery()->find($task_id);

        try {
            $task->update([
                "title" => $request->get('title'),
                "description" => $request->get('description'),
                "project_task_category_id" => $request->get('project_task_category_id')
            ]);

            foreach ($project->users as $user) {
                $user->notify(new EditTaskNotification($project, $task));
            }

            projectActivityStore($project->id, "fas fa-edit", "Edition d'une tache", "La tache <strong>{$task->title}</strong> à été éditer par " . auth()->user()->name, "success");
            return response()->json($task);
        } catch (\Exception $exception) {
            return response()->json(["error" => "Erreur lors de la mise à jour de la tache", "msg" => $exception->getMessage()]);
        }
    }

    public function deleteTask($project_id, $task_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $task = $this->projectTask->newQuery()->find($task_id);

        try {
            $task->delete();

            foreach ($project->users as $user) {
                $user->notify(new DeleteTaskNotification($project, $task));
            }

            projectActivityStore($project->id, "fas fa-trash", "Suppression d'une tache", "La tache <strong>{$task->title}</strong> à été supprimer par " . auth()->user()->name, "success");

            return response()->json();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function closeTask($project_id, $task_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $task = $this->projectTask->newQuery()->find($task_id);

        try {
            $task->update([
                "state" => 1
            ]);

            foreach ($project->users as $user) {
                $user->notify(new StateTaskNotification($project, $task));
            }

            projectActivityStore($project->id, "fas fa-lock", "Cloture d'une tache", "La tache <strong>{$task->title}</strong> à été cloturer par " . auth()->user()->name, "success");

            return response()->json($task);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function openTask($project_id, $task_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $task = $this->projectTask->newQuery()->find($task_id);

        try {
            $task->update([
                "state" => 0
            ]);

            foreach ($project->users as $user) {
                $user->notify(new StateTaskNotification($project, $task));
            }

            projectActivityStore($project->id, "fas fa-lock", "Ouverture d'une tache", "La tache <strong>{$task->title}</strong> à été ouvert par " . auth()->user()->name, "success");

            return response()->json($task);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function listFiles($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $array = [];

        foreach ($project->files as $file) {
            $array[] = [
                "type" => $file->type,
                "name" => $file->name,
                "uri" => $file->uri,
                "size" => $file->size,
                "created_at" => $file->created_at->format("d/m/Y à H:i"),
                "id" => $file->id
            ];
        }

        return response()->json(["files" => $array]);
    }

    /**
     * @param Request $request
     * @param $project_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchFiles(Request $request, $project_id)
    {
        //dd($request->all());
        $project = $this->project->newQuery()->find($project_id)->files()->where('name', 'LIKE', '%' . $request->get('q') . '%')->get();
        $array = [];

        foreach ($project as $file) {
            $array[] = [
                "type" => $file->type,
                "name" => $file->name,
                "uri" => $file->uri,
                "size" => $file->size,
                "created_at" => $file->created_at->format("d/m/Y à H:i"),
                "id" => $file->id
            ];
        }

        return response()->json(["files" => $array]);
    }

    public function getMessages($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $arr = [];

        foreach ($project->conversations as $conversation) {
            $arr[] = [
                "message" => $conversation->message,
                "user" => $conversation->user,
                "date" => $conversation->created_at->longAbsoluteDiffForHumans()
            ];
        }

        return response()->json([
            "data" => $arr
        ]);
    }

    public function postMessages(Request $request, $project_id)
    {
        $message = $this->project->conversations()->create([
            "message" => $request->get('message'),
            "project_id" => $project_id,
            "user_id" => auth()->user()->id,
        ]);

        return response()->json([
            "data" => [
                "message" => $request->get('message'),
                "user" => $message->user(),
                "date" => $message->created_at->longAbsoluteDiffForHumans()
            ]
        ]);
    }
}

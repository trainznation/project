<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\User;
use App\Notifications\Project\AddingTaskNotification;
use App\Notifications\Project\AttachProject;
use App\Notifications\Project\CreateAuthorNotification;
use App\Notifications\Project\UploadFileNotification;
use Illuminate\Http\Request;
use Storage;

class ProjectController extends Controller
{
    /**
     * @var Project
     */
    private $project;
    /**
     * @var User[]|\Illuminate\Database\Eloquent\Collection
     */
    private $users;

    /**
     * ProjectController constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->users = User::all();
    }

    public function index()
    {
        $projects = auth()->user()->projects()->orderBy('id', 'desc');
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        return view('project.create');
    }

    public function store(CreateProjectRequest $request)
    {
        try {
            $project = $this->project->newQuery()->create($request->except('files'));
            $project->users()->attach(auth()->user());
            projectActivityStore($project->id, "fas fa-plus", "Nouveau Projet", "Le projet <strong>{$project->title}</strong> à été créer par ".auth()->user()->name, "success");
            auth()->user()->notify(new CreateAuthorNotification($project));
            return redirect()->route('project.index')->with('success', "Le projet {$project->title} à été créer avec succès");
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', "Erreur lors de la création de projet.<br>{$exception->getMessage()}");
        }
    }

    public function show($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        return view('project.show', compact('project'));
    }

    public function tasks($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        return view('project.tasks', compact('project'));
    }

    public function files($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        return view('project.files', compact('project'));
    }

    public function addUsers(Request $request, $project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        foreach ($request->get('users') as $user) {
            $us = User::find($user);
            $project->users()->attach($user);
            $us->notify(new AttachProject($project));
        }

        projectActivityStore($project->id, "fas fa-user-plus", "Ajout de contributeurs au projet", "Un ou plusieurs contributeur ont été ajoutés au projet par ".auth()->user()->name, "success");

        return redirect()->back()->with('success', "Les utilisateurs ont été ajouter au projet.");
    }

    public function addTask(Request $request, $project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        try {
            $task = $project->tasks()->create([
                "title" => $request->get('title'),
                "description" => $request->get('description')
            ]);

            foreach ($project->users as $user) {
                $user->notify(new AddingTaskNotification($project));
            }

            projectActivityStore($project->id, "fas fa-tasks", "Nouvelle tache", "La tache <strong>{$task->title}</strong> à été ajouté au projet par ".auth()->user()->name, "success");
            return redirect()->back()->with('success', "La Tâche <strong>{$task->title}</strong> pour le projet <strong>{$project->title}</strong> à été ajouter");
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function uploadFile(Request $request, $project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        foreach ($request->all() as $file) {
            $directory = public_path('storage/files/project/'.$project_id.'/'.$file->getClientOriginalName());
            $file->storeAs('files/project/'.$project_id.'/', $file->getClientOriginalName(), 'public');

            ProjectFile::insert([
                "type" => $file->extension(),
                "name" => $file->getClientOriginalName(),
                "uri" => "/storage/files/project/{$project_id}/{$file->getClientOriginalName()}",
                "size" => filesize($directory),
                "user_id" => auth()->user()->id,
                "project_id" => $project_id,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        foreach ($this->users as $user) {
            $user->notify(new UploadFileNotification($project));
        }

        projectActivityStore($project->id, "far fa-copy", "Ajout de fichier", "Un ou plusieurs fichiers ont été ajoutés au projet par ".auth()->user()->name, "success");

        return response()->json();
    }

    public function fileView($project_id, $file_id)
    {
        $project = $this->project->newQuery()->find($project_id);
        $file = $project->files()->find($file_id);

        return view('project.file_view', compact('project', 'file'));
    }

    public function activity($project_id)
    {
        $project = $this->project->newQuery()->find($project_id);

        return view('project.activity', compact('project'));
    }
}

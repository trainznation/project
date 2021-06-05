<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
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
            return redirect()->route('project.index')->with('success', "Le projet {$project->title} à été créer avec succès");
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', "Erreur lors de la création de projet.<br>{$exception->getMessage()}");
        }
    }
}

<?php
if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return Route::currentRouteNamed($route) ? 'active' : '';
    }
}

if (!function_exists('stateLabelProject')) {
    function stateLabelProject($state)
    {
        switch ($state) {
            case 0: return '<span class="badge badge-light-warning fw-bolder me-auto px-4 py-3">En cours</span>';
            case 1: return '<span class="badge badge-light-success fw-bolder me-auto px-4 py-3">Terminer</span>';
            case 2: return '<span class="badge badge-light-danger fw-bolder me-auto px-4 py-3">Annuler</span>';
            case 3: return '<span class="badge badge-light-info fw-bolder me-auto px-4 py-3">En attente</span>';
            default; return null;
        }
    }
}

if (!function_exists('stateProgressStateTask')) {
    function stateProgressStateTask($project_id)
    {
        $project = new \App\Models\Project();
        $proj = $project->newQuery()->find($project_id);

        $terminate_task = $proj->tasks()->where('state', 1)->count();
        $all_task = $proj->tasks()->count();

        $percent = ($terminate_task/100*$all_task)*100;
        $percent_format = number_format($percent, 1, '.', '');

        return '<div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project '.$percent_format.'% completed">
                        <div class="bg-primary rounded h-4px" role="progressbar" style="width: '.$percent_format.'%" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>';
    }
}

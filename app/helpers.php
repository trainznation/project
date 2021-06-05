<?php
if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return Route::currentRouteNamed($route) ? 'active' : '';
    }
}

if (!function_exists('stateLabelProject')) {
    function stateLabelProject($state, $text = false)
    {
        if ($text == false) {
            switch ($state) {
                case 0:
                    return '<span class="badge badge-light-warning fw-bolder me-auto px-4 py-3">En cours</span>';
                case 1:
                    return '<span class="badge badge-light-success fw-bolder me-auto px-4 py-3">Terminer</span>';
                case 2:
                    return '<span class="badge badge-light-danger fw-bolder me-auto px-4 py-3">Annuler</span>';
                case 3:
                    return '<span class="badge badge-light-info fw-bolder me-auto px-4 py-3">En attente</span>';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return 'En cours';
                case 1:
                    return 'Terminer';
                case 2:
                    return 'Annuler';
                case 3:
                    return 'En attente';
                default;
                    return null;
            }
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

        $percent = ($terminate_task / 100 * $all_task) * 100;
        $percent_format = number_format($percent, 1, '.', '');

        return '<div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="Le projet est à ' . $percent_format . '% Compléter">
                        <div class="bg-primary rounded h-4px" role="progressbar" style="width: ' . $percent_format . '%" aria-valuenow="' . $percent . '" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>';
    }
}

if (!function_exists('statePublishProject')) {
    function statePublishProject($state, $text = false)
    {
        if ($text == false) {
            switch ($state) {
                case 0:
                    return '<span class="badge badge-primary fw-bolder me-auto px-4 py-3">Corbeille</span>';
                case 1:
                    return '<span class="badge badge-danger fw-bolder me-auto px-4 py-3">Priver</span>';
                case 2:
                    return '<span class="badge badge-success fw-bolder me-auto px-4 py-3">Public</span>';
                default;
                    return null;
            }
        } else {
            switch ($state) {
                case 0:
                    return 'corbeille';
                case 1:
                    return 'priver';
                case 2:
                    return 'public';
                default;
                    return null;
            }
        }
    }
}

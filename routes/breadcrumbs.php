<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Tableau de Bord', route('dashboard'));
});

Breadcrumbs::for('project', function (BreadcrumbTrail $trail) {
    $trail->push('Mes Projets', route('project.index'));
});

Breadcrumbs::for('project_create', function (BreadcrumbTrail $trail) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push("Création d'un projet", route('project.create'));
});

Breadcrumbs::for('project_show', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
});

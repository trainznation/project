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

Breadcrumbs::for('project_show_tasks', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
    $trail->push("Liste des Tâches", route('project.tasks', $project->id));
});

Breadcrumbs::for('project_show_files', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
    $trail->push("Gestionnaire de Fichiers", route('project.files', $project->id));
});

Breadcrumbs::for('project_show_activity', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
    $trail->push("Activités du projet", route('project.activity', $project->id));
});

Breadcrumbs::for('project_show_conversation', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
    $trail->push("Conversation du projet", route('project.conversations', $project->id));
});

Breadcrumbs::for('project_show_setting', function (BreadcrumbTrail $trail, $project) {
    $trail->push('Mes Projets', route('project.index'));
    $trail->push($project->title, route('project.show', $project->id));
    $trail->push("Configuration du projet", route('project.setting', $project->id));
});

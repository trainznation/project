<?php

namespace App\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteTaskNotification extends Notification
{
    use Queueable;

    private $project;
    private $task;

    /**
     * Create a new notification instance.
     *
     * @param $project
     * @param $task
     */
    public function __construct($project, $task)
    {
        //
        $this->project = $project;
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "icon" => "fas fa-trask",
            "color" => "danger",
            "title" => "Suppression d'une tache",
            "text" => "La tache <strong>{$this->task->title}</strong> du projet <strong>{$this->project->title}</strong> à été supprimer."
        ];
    }
}

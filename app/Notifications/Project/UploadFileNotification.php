<?php

namespace App\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UploadFileNotification extends Notification
{
    use Queueable;

    private $project;

    /**
     * Create a new notification instance.
     *
     * @param $project
     */
    public function __construct($project)
    {
        //
        $this->project = $project;
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
            "icon" => "far fa-file-alt",
            "color" => "success",
            "title" => "Nouveau fichiers disponible",
            "text" => "De nouveau fichiers pour le projet {$this->project->title} sont disponible !"
        ];
    }
}

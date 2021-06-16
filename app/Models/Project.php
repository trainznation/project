<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ["created_at", "updated_at", "time_start"];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function conversations()
    {
        return $this->hasMany(ProjectConversation::class);
    }

    public function activities()
    {
        return $this->hasMany(ProjectActivity::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function tasks() {
        return $this->hasOne(ProjectTask::class);
    }
}

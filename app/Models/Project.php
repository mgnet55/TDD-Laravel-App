<?php

namespace App\Models;

use App\Observers\ProjectObserver;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'description',
        'owner_id',
        'notes'
    ];

    public function path()
    {
        return "/projects/{$this->id}";
    }


    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);

        // TODO Sorting Tasks by Completed Status then by recently added
        //->orderBy("completed');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest()->latest('id');
    }

    public function addTask(string $task)
    {
        return $this->tasks()->create(['body' => $task]);
    }


}

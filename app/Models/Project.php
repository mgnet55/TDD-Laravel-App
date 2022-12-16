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

    protected static array $recordableActivities = ['created', 'updated'];

    public function path(): string
    {
        return "/projects/{$this->id}";
    }


    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('completed')->orderBy('id');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest('id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_member')->withTimestamps();
    }

    public function addTask(string $task)
    {
        return $this->tasks()->create(['body' => $task]);
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }


}

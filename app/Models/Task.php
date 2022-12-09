<?php

namespace App\Models;

use App\Observers\TaskObserver;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = ['project'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path(): string
    {
        return "/projects/$this->project_id/tasks/$this->id";

    }

    public function complete(): void
    {

        $this->fill(['completed' => true])->saveQuietly() && $this->recordActivity('completed_task', true);

    }

    public function incomplete(): void
    {
        $this->fill(['completed' => false])->saveQuietly() && $this->recordActivity('uncompleted_task', true);
    }


}

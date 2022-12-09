<?php

namespace App\Traits;

use App\Models\Activity;

trait RecordsActivity
{

    public static function bootRecordsActivity(): void
    {
        foreach (self::getRecordableActivities() as $event) {
            static::$event(static function ($model) use ($event) {

                $model->recordActivity($model->generateActivityDescription($event));
            });
        }

    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest('id');
    }


    public function recordActivity($description, $withoutChanges = false)
    {
        return
            $this->activity()->create([
                'description' => $description,
                'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
                'changes' => $withoutChanges ? null : $this->getActivityChanges()
            ]);

    }

    protected function getActivityChanges(): ?array

    {
        if ($this->wasChanged()) {

            $after = \Arr::except($this->getChanges(), 'updated_at');

            return [
                'before' => array_intersect_key($this->getOriginal(), $after),
                'after' => $after
            ];
        }
        return null;

    }

    /**
     * @return string[]
     */
    public static function getRecordableActivities(): array
    {
        return static::$recordableActivities ?? ['created', 'updated', 'deleted'];
    }

    /**
     * @param $event
     * @return string
     */
    public function generateActivityDescription($event): string
    {
        return $event . '_' . strtolower(class_basename($this));
    }


}

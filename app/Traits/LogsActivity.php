<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

/**
 * Mencatat setiap create/update/delete pada model ke tabel activity_logs
 * secara otomatis lewat Eloquent model events.
 */
trait LogsActivity
{
    /**
     * Snapshot atribut asli sebelum update, dikunci per-instance lewat spl_object_id
     * karena event "updating" dan "updated" menerima instance model yang sama.
     */
    protected static array $activityLogOriginal = [];

    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->recordActivity('created', [
                'new' => $model->activityLoggableAttributes($model->getAttributes()),
            ]);
        });

        static::updating(function ($model) {
            static::$activityLogOriginal[spl_object_id($model)] = $model->getOriginal();
        });

        static::updated(function ($model) {
            $key = spl_object_id($model);
            $original = static::$activityLogOriginal[$key] ?? [];
            unset(static::$activityLogOriginal[$key]);

            $changedKeys = array_keys($model->activityLoggableAttributes($model->getChanges()));

            if (empty($changedKeys)) {
                return;
            }

            $model->recordActivity('updated', [
                'old' => $model->activityLoggableAttributes(array_intersect_key($original, array_flip($changedKeys))),
                'new' => $model->activityLoggableAttributes(array_intersect_key($model->getAttributes(), array_flip($changedKeys))),
            ]);
        });

        static::deleted(function ($model) {
            $model->recordActivity('deleted', [
                'old' => $model->activityLoggableAttributes($model->getAttributes()),
            ]);
        });
    }

    /**
     * Buang kolom yang tidak relevan / sensitif dari log.
     */
    protected function activityLoggableAttributes(array $attributes): array
    {
        return collect($attributes)
            ->except(['created_at', 'updated_at', 'deleted_at', 'password', 'remember_token'])
            ->toArray();
    }

    protected function recordActivity(string $action, array $changes = []): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => class_basename($this),
            'subject_id' => $this->getKey(),
            'changes' => $changes,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}

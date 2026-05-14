<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLoggerService
{
    public function log(
        string $action,
        ?string $description = null,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }

    public function created(Model $model, ?string $description = null): ActivityLog
    {
        return $this->log('created', $description ?? $this->defaultDescription($model, 'membuat'), $model, null, $model->toArray());
    }

    public function updated(Model $model, array $oldValues, ?string $description = null): ActivityLog
    {
        return $this->log('updated', $description ?? $this->defaultDescription($model, 'memperbarui'), $model, $oldValues, $model->toArray());
    }

    public function deleted(Model $model, ?string $description = null): ActivityLog
    {
        return $this->log('deleted', $description ?? $this->defaultDescription($model, 'menghapus'), $model, $model->toArray(), null);
    }

    public function login(): ActivityLog
    {
        return $this->log('login', 'Login ke sistem');
    }

    public function logout(): ActivityLog
    {
        return $this->log('logout', 'Logout dari sistem');
    }

    private function defaultDescription(Model $model, string $action): string
    {
        $name = method_exists($model, 'getName') ? $model->getName() : ($model->title ?? $model->name ?? $model->id);
        return class_basename($model) . " '{$name}' {$action}";
    }
}

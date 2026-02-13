<?php

namespace App\Observers;

use App\Helpers\LogActivityHelper;
use App\Models\LogAktivitas;

class GlobalCrudObserver
{
    protected array $ignore = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function created($model)
    {
        if ($model instanceof LogAktivitas) return;

        LogActivityHelper::log(
            'Create data ' . class_basename($model) . ' ID: ' . $model->id,
            null,
            $model->getAttributes()
        );
    }

    public function updated($model)
    {
        if ($model instanceof LogAktivitas) return;

        $before = $model->getOriginal();
        $after  = $model->getChanges();

        $filteredBefore = [];
        $filteredAfter  = [];

        foreach ($after as $field => $value) {

            if (in_array($field, $this->ignore)) {
                continue;
            }

            $filteredBefore[$field] = $before[$field] ?? null;
            $filteredAfter[$field]  = $value;
        }

        if (!empty($filteredAfter)) {
            LogActivityHelper::log(
                'Update ' . class_basename($model) . ' ID: ' . $model->id,
                $filteredBefore,
                $filteredAfter
            );
        }
    }

    public function deleted($model)
    {
        if ($model instanceof LogAktivitas) return;

        LogActivityHelper::log(
            'Delete data ' . class_basename($model) . ' ID: ' . $model->id,
            $model->getOriginal(),
            null
        );
    }
}

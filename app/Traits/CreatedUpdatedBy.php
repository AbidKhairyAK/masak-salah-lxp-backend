<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        static::creating(function ($model) {
            $user = Auth::check() ? Auth::user()->name : 'admin system';
            $model->created_by = $user;
            $model->updated_by = $user;
        });

        static::updating(function ($model) {
            $user = Auth::check() ? Auth::user()->name : 'admin system';
            $model->updated_by = $user;
        });
    }
}

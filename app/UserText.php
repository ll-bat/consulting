<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserText extends Model
{
     protected $fillable = ['user_id','field_id','danger_id', 'export_id', 'name', 'created_at', 'updated_at', 'type', 'is_ignored'];

    /**
     * @return BelongsTo
     */
     public function getUser(): BelongsTo
     {
         return $this->belongsTo(User::class, 'user_id');
     }

    /**
     * @return BelongsTo
     */
     public function dangers(): BelongsTo
     {
         return $this->belongsTo(Danger::class, 'danger_id');
     }
}

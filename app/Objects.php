<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Objects
 * @package App
 * @property integer $id
 * @property string $name
 */
class Objects extends Model
{
    protected $fillable = ['user_id', 'name'];

    /**
     * @return HasMany
     */
    public function getDocs(): HasMany
    {
        return $this->hasMany(Export::class);
    }

    /**
     * @return mixed
     */
    public function getDocsCount() {
        return Export::where(['object_id' => $this->id])->count();
    }
}

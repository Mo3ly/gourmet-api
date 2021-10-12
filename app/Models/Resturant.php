<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $media_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $desc_ar
 * @property string $desc_en
 * @property string $category
 * @property boolean $enabled
 * @property string $created_at
 * @property Media $media
 */
class Resturant extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';
    
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'media_id', 
        'name_ar', 
        'name_en', 
        'desc_ar', 
        'desc_en', 
        'category', 
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getMedia()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function getMenuCategories()
    {
        return $this->hasMany(MenuCategory::class, 'resturant_id', 'id');
    }
}

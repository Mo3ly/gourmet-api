<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $resturant_id
 * @property integer $media_id
 * @property string $name_ar
 * @property string $name_en
 * @property string $desc_ar
 * @property string $desc_en
 * @property string $category
 * @property string $created_at
 * @property string $updated_at
 * @property Media $media
 * @property Resturant $resturant
 */
class MenuCategory extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';
    
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'resturant_id', 
        'media_id', 
        'name_ar', 
        'name_en', 
        'desc_ar', 
        'desc_en',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getMedia()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getResturant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function getMenuProducts()
    {
        return $this->hasMany(MenuProduct::class, 'category_id', 'id');
    }
}

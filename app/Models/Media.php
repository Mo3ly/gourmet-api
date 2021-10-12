<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID
 * @property string $Title
 * @property string $Type
 * @property string $Url
 */
class Media extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'media';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['id', 'title', 'type', 'url'];

}

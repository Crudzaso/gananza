<?php

namespace Modules\Multimedia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Raffle\Models\Raffle;

class Multimedia extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'size',
        'model_id',
        'model_type',
    ];

    // Si tienes un Factory, puedes activarlo aquí
    // protected static function newFactory(): MultimediaFactory
    // {
    //     return MultimediaFactory::new();
    // }

    
       public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}

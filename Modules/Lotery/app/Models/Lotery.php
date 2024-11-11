<?php

namespace Modules\Lotery\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lotery extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'lotteries';  // Especificamos la tabla correctamente

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'url_imagen'];  // Agregar 'description' e 'image_url' para la asignación masiva

    /**
     * Las relaciones de los sorteos con esta lotería (relación inversa).
     */
    public function draws()
    {
        return $this->hasMany(\Modules\Draws\Models\Draws::class, 'lottery_id');
    }
}

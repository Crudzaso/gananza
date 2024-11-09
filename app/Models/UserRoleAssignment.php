<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class UserRoleAssignment extends Model
{
    protected $table = 'model_has_roles';
    
    public $timestamps = false;
    
    protected $fillable = [
        'role_id',
        'model_id',
        'model_type'
    ];

    // No definimos primaryKey compuesta aquí
    protected $primaryKey = 'role_id'; // Usamos solo role_id como primary key para Filament

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
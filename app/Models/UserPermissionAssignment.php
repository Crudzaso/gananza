<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;

class UserPermissionAssignment extends Model
{
    protected $table = 'model_has_permissions';
    
    public $timestamps = false;
    
    protected $fillable = [
        'permission_id',
        'model_id',
        'model_type'
    ];

    protected $primaryKey = 'permission_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public static function getLabel(): string
    {
        return 'Permission assignment';
    }

    public static function getPluralLabel(): string
    {
        return 'Permission assignments';
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'model_id',
        'model_type',
        'action',
        'detail',          
    ];

     /**
     * Los repuestos que puede tener un contrato.
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function scopeModel($query, $model)
    {
        $query->where('model_type',$model);
    }

}

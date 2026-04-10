<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'boats';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'security_number',
        'name',
        'type',
        'status',
        'assigned_operator_id',
        'home_port',
        'specifications',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'specifications' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the operator assigned to this boat.
     */
    public function assignedOperator()
    {
        return $this->belongsTo(User::class, 'assigned_operator_id');
    }

    /**
     * Get all boats with a specific status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get all active boats.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    /**
     * Get all boats assigned to an operator.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_operator_id', $userId);
    }
}

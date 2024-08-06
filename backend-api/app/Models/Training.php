<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subordinates()
    {
        return $this->belongsToMany(User::class, 'subordinate_training', 'training_id', 'subordinate_id')
            ->withPivot('status')
            ->withTimestamps();
    }
}

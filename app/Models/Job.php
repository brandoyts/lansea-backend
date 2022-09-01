<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:i:s',
    //     'updated_at' => 'datetime:Y-m-d H:i:s',
    // ];

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
    ];

    protected $dateFormat = 'U';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

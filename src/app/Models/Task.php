<?php

namespace App\Models;

use App\Notifications\TaskStatusNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relação com o usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method for the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->user->notify(new TaskStatusNotification($task));
        });

        static::updated(function ($task) {
            $task->user->notify(new TaskStatusNotification($task));
        });
    }
}

<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskStatusNotification extends Notification
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param  Task  $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Atualização de Status da Tarefa')
            ->greeting("Olá, {$notifiable->name}!")
            ->line('A tarefa abaixo foi atualizada:')
            ->line('Título: ' . $this->task->title)
            ->line('Status: ' . $this->task->status)
            ->line('Prazo: ' . Carbon::parse($this->task->deadline)->format('d/m/Y H:i'))
            ->action('Ver Tarefa', url('/tasks/' . $this->task->id))
            ->line('Obrigado por usar nossa aplicação!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'status' => $this->task->status,
        ];
    }
}

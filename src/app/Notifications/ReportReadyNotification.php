<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReportReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $fileName;

    /**
     * Cria uma nova instância de notificação.
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Defina os canais de entrega da notificação.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Obtenha a representação de email da notificação.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url('/api/reports/download?file=' . urlencode($this->fileName));

        return (new MailMessage)
            ->subject('Seu relatório está pronto para download')
            ->greeting("Olá, {$notifiable->name}!")
            ->line('Seu relatório de tarefas está pronto.')
            ->action('Baixar Relatório', $url)
            ->line('Obrigado por usar nossa aplicação!');
    }

    /**
     * Obtenha o array de representação da notificação.
     */
    public function toArray($notifiable): array
    {
        return [
            'file_name' => $this->fileName,
        ];
    }
}

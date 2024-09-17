<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReportReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class GenerateTasksReportJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    private User $user;

    /**
     * Cria uma nova instância do job.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Executa o job.
     */
    public function handle()
    {
        $tasks = $this->user->tasks()->select('title', 'status', 'deadline')->get();

        $csvData = $this->generateCSV($tasks);

        $fileName = 'reports/tasks_report_user_' . $this->user->id . '_' . time() . '.csv';
        Storage::disk('local')->put($fileName, $csvData);

        $this->user->notify(new ReportReadyNotification($fileName));
    }

    /**
     * Gera o conteúdo CSV a partir dos dados das tarefas.
     */
    private function generateCSV($tasks): string
    {
        $header = ['Título', 'Status', 'Deadline'];
        $rows = $tasks->map(function ($task) {
            return [
                $task->title,
                $task->status,
                $task->deadline ? $task->deadline->toDateString() : 'Sem deadline',
            ];
        });

        $data = collect([$header])->merge($rows);

        return $data->map(function ($row) {
            return implode(',', $row);
        })->implode("\n");
    }
}

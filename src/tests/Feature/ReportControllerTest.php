<?php

namespace Tests\Feature;

use App\Jobs\GenerateTasksReportJob;
use App\Notifications\ReportReadyNotification;
use App\Notifications\TaskStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Queue::fake();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /**
     * Test generate report endpoint.
     *
     * @return void
     */
    public function test_generate_report()
    {
        $response = $this->post('/api/reports/tasks');

        $response->assertStatus(202) // Assuming the report generation starts and responds with 202
            ->assertJson([
                'message' => 'A geração do relatório foi iniciada. Você receberá um email quando estiver pronto.'
            ]);

        Queue::assertPushed(GenerateTasksReportJob::class);
    }


    /**
     * Test download report endpoint.
     *
     * @return void
     */
    public function test_download_report()
    {
        $filename = "reports/tasks_report_user_{$this->user->id}_123456.csv";
        Storage::fake('local');
        $csvContent = "id,title,status,deadline\n1,Test Task,completed,2024-12-31";
        Storage::disk('local')->put($filename, $csvContent);

        $response = $this->get("/api/reports/download?file=$filename");

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        Storage::disk('local')->assertExists($filename);
    }
}

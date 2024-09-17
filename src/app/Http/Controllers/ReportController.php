<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateTasksReportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Gera um relatório de tarefas.
     */
    public function generateTasksReport(): JsonResponse
    {
        $user = Auth::user();

        GenerateTasksReportJob::dispatch($user);

        return response()->json([
            'message' => 'A geração do relatório foi iniciada. Você receberá um email quando estiver pronto.',
        ], 202);
    }

    /**
     * Baixa um relatório de tarefas.
     */
    public function downloadReport(Request $request)
    {
        $fileName = $request->query('file');

        if (!Storage::disk('local')->exists($fileName)) {
            return response()->json(['message' => 'Arquivo não encontrado.'], 404);
        }

        $userIdInFileName = (int) explode('_', $fileName)[3];

        if ($userIdInFileName !== Auth::id()) {
            return response()->json(['message' => 'Você não tem permissão para baixar este arquivo.'], 403);
        }

        return Storage::disk('local')->download($fileName);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Lista as tarefas.
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getAllByUserId(Auth::id());

        return response()->json(TaskResource::collection($tasks));
    }

    /**
     * Armazena uma nova tarefa.
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $task = $this->taskRepository->create($data);

        // Disparar evento ou job para enviar notificação por email

        return response()->json(new TaskResource($task), 201);
    }

    /**
     * Exibe uma tarefa específica.
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->taskRepository->findById($id);

        $this->authorizeTask($task);

        return response()->json(new TaskResource($task));
    }

    /**
     * Atualiza uma tarefa existente.
     */
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $task = $this->taskRepository->findById($id);

        $this->authorizeTask($task);

        $this->taskRepository->update($task, $request->validated());

        // Disparar evento ou job para enviar notificação por email

        return response()->json(new TaskResource($task));
    }

    /**
     * Remove uma tarefa.
     */
    public function destroy(int $id): JsonResponse
    {
        $task = $this->taskRepository->findById($id);

        $this->authorizeTask($task);

        $this->taskRepository->delete($task);

        return response()->json(null, status: 204);
    }

    /**
     * Conclui uma tarefa.
     */
    public function complete(int $id): JsonResponse
    {
        $task = $this->taskRepository->findById($id);

        $this->authorizeTask($task);

        $this->taskRepository->update($task, ['status' => 'Concluída']);

        return response()->json(new TaskResource($task));
    }

    /**
     * Autoriza o acesso à tarefa.
     */
    private function authorizeTask(?Task $task): void
    {
        if (!$task || $task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Acesso não autorizado à tarefa.'], 403);
        }
    }
}

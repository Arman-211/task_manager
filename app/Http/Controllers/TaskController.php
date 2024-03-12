<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Services\TaskServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    /**
     * TaskController constructor.
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Get all tasks.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks($request->get('status'));
        return response()->json($tasks);
    }

    /**
     * Create a new task.
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $task = $this->taskService->createTask($request->all());
            return response()->json($task, 201);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get a single task by ID.
     * @param int $taskId
     * @return JsonResponse
     */
    public function show(int $taskId): JsonResponse
    {
        $task = $this->taskService->getTaskById($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update an existing task.
     * @param UpdateRequest $request
     * @param int $taskId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $taskId): JsonResponse
    {
        $task = $this->taskService->getTaskById($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        try {
            $task = $this->taskService->updateTask($task, $request->all());
            return response()->json($task);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Delete a task by ID.
     * @param int $taskId
     * @return JsonResponse
     */
    public function destroy(int $taskId): JsonResponse
    {
        $task = $this->taskService->getTaskById($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        try {
            $this->taskService->deleteTask($task);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Handle exceptions.
     * @param Exception $e
     * @return JsonResponse
     */
    protected function handleException(Exception $e): JsonResponse
    {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

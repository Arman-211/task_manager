<?php

namespace App\Contracts\ReadRepositories;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskReadRepositoryInterface
{
    /**
     * Get all tasks based on filters.
     *
     * @param string|null $status
     * @return Collection
     */
    public function getAll(?string $status): Collection;

    /**
     * Get a task by ID.
     *
     * @param int $taskId
     * @return Task|null
     */
    public function getById(int $taskId): ?Task;
}

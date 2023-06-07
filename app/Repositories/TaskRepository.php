<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use App\Contract\TaskRepositoryInterface;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

    public function getAllTasks($projectId, Request $request)
    {

        $project = Project::findOrFail($projectId);

        return $project->tasks;
    }

    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function deleteTask($id)
    {

        $task = $this->getTaskById($id);

        return $task->delete();
    }

    public function createTask(array $attributes)
    {
        return Task::create($attributes);
    }

    public function updateTask($id, array $attributes)
    {

        $task = $this->getTaskById($id);

        return $task->update($attributes);
    }
}

<?php

namespace App\Contract;


use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function getAllTasks($projectId, Request $request);
    public function getTaskById($id);
    public function deleteTask($id);
    public function createTask(array $attributes);
    public function updateTask($id, array $attributes);
}

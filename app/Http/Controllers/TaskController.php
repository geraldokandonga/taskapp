<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contract\TaskRepositoryInterface;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

class TaskController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct(
        private TaskRepositoryInterface $repository
    ) {
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $attributes = $request->only([
            'name',
            'priority',
            'project_id'
        ]);

        $newTask = $this->repository->createTask($attributes);

        if ($newTask) {
            return response()->json([
                'data' =>  $newTask,
                'status' => 'success',
                'message' => "Task created successfully"
            ]);
        }

        return response()->json([
            'data' =>  null,
            'status' => 'error',
            'message' => "Could not create task"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {

        $task = $this->repository->getTaskById($id);

        if ($task) {
            return response()->json([
                'data' => $task,
                'status' => 'success',
            ]);
        }

        return response()->json([
            'data' => null,
            'status' => 'error',
            'message' => "Invalid task"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): JsonResponse
    {

        $formRequest = $request->all();

        $response = [
            'status' => 'error',
            'message' => 'Something went wrong.'
        ];

        if (isset($formRequest['action']) && $formRequest['action'] == 'priority') {
            //You are going to update task priority by drag and drop
            foreach ($formRequest['order'] as $row) {
                Task::where('id', $row['id'])->update(['priority' => $row['priority']]);
            }

            $response = [
                'status' => 'success',
                'message' => 'Priority has been updated successfully.',
                'html' => view('task.partials.list', ['tasks' => Task::getAllTasks()])->render()
            ];
        } else {
            $formRequest = array_map('trim', $formRequest);
            if (empty($formRequest['id'])) {
                //You are going to add new task
                $task = Task::getTaskByName($formRequest['name']);
                if ($task) {
                    //Duplication with name
                    $response = [
                        'status' => 'error',
                        'message' => 'A duplicated task exists',
                    ];
                } else {
                    $task = new Task;
                    $task->name = $formRequest['name'];
                    $task->priority = $formRequest['priority'];

                    if ($task->save()) {
                        $response = [
                            'status' => 'success',
                            'message' => 'You have added a task successfully.',
                            'html' => view('task.partials.list', ['tasks' => Task::getAllTasks()])->render()
                        ];
                    }
                }
            } else {
                // Update existing task
                if (Task::isDuplicated($formRequest['id'], $formRequest['name'])) {
                    // Throw error if task is duplicated
                    $response = [
                        'status' => 'error',
                        'message' => 'A duplicated task exists.',
                    ];
                } else {
                    $task = Task::find($formRequest['id']);
                    if ($task) {
                        $task->name = $formRequest['name'];
                        $task->priority = $formRequest['priority'];
                        if ($task->save()) {
                            $response = [
                                'status' => 'success',
                                'message' => 'You have updated a task successfully.',
                                'html' => view('task.partials.list', ['tasks' => Task::getAllTasks()])->render()
                            ];
                        }
                    } else {
                        //No such task
                        $response = [
                            'status' => 'error',
                            'message' => 'There is no such task.',
                        ];
                    }
                }
            }
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $task  = $this->repository->deleteTask($id);

        if ($task) {
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Could not delete task.'
        ]);
    }
}

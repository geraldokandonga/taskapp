<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contract\TaskRepositoryInterface;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Models\Project;

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
    public function update(Request $request): JsonResponse
    {

        $input = $request->all();

        // project from id
        $project = Project::findOrFail($input['project_id']);

        $response = [
            'status' => 'error',
            'message' => 'Something went wrong.'
        ];

        if (isset($input['action']) && $input['action'] == 'priority') {
            //You are going to update task priority by drag and drop
            foreach ($input['order'] as $row) {
                Task::where('id', $row['id'])->update(['priority' => $row['priority']]);
            }

            $response = [
                'status' => 'success',
                'message' => 'Priority has been updated successfully.',
                'html' => view('task.partials.list', ['tasks' => $project->tasks])->render()
            ];
        } else {
            $input = array_map('trim', $input);
            if (empty($input['id'])) {
                //You are going to add new task
                $task = Task::getTaskByName($input['name']);
                if ($task) {
                    //Duplication with name
                    $response = [
                        'status' => 'error',
                        'message' => 'A duplicated task exists',
                    ];
                } else {
                    $task = new Task;
                    $task->name = $input['name'];
                    $task->priority = $input['priority'];

                    if ($task->save()) {
                        $response = [
                            'status' => 'success',
                            'message' => 'You have added a task successfully.',
                            'html' => view('task.partials.list', ['tasks' => $project->tasks])->render()
                        ];
                    }
                }
            } else {
                // Update existing task
                if (Task::isDuplicated($input['id'], $input['name'])) {
                    // Throw error if task is duplicated
                    $response = [
                        'status' => 'error',
                        'message' => 'A duplicated task exists.',
                    ];
                } else {
                    $task = $this->repository->getTaskById($input['id']);
                    if ($task) {
                        $task->name = $input['name'];
                        $task->priority = $input['priority'];
                        if ($task->save()) {
                            $response = [
                                'status' => 'success',
                                'message' => 'You have updated a task successfully.',
                                'html' => view('task.partials.list', ['tasks' => $project->tasks])->render()
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

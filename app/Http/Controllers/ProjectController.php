<?php

namespace App\Http\Controllers;


use App\Models\Project;
use Illuminate\Http\Response;
use App\Contract\ProjectRepositoryInterface;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function __construct(
        private ProjectRepositoryInterface $repository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $selectedProjectId = $request->query('project_id');

        $projects = $this->repository->getAllProjects();

        return view('home', compact('projects', 'selectedProjectId'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $attributes = $request->only([
            'name',
        ]);

        $newProject = $this->repository->createProject($attributes);

        if ($newProject) {
            return response()->json([
                'data' =>  $newProject,
                'status' => 'success',
                'message' => "Projected successfully"
            ]);
        }


        return response()->json([
            'data' =>  null,
            'status' => 'error',
            'message' => "Could not create project"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $project = $this->repository->getProjectById($id);

        $tasks = $project->tasks;

        return view('task.index', compact('tasks', 'project'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $attributes = $request->only([
            'name',
        ]);

        $updateProject = $this->repository->updateProject($project, $attributes);

        if ($updateProject) {
            return response()->json(
                [
                    'data' =>  $updateProject,
                    'status' => 'success',
                    'message' => "Projected updated successfully"
                ],
            );
        }

        return response()->json([
            'data' =>  null,
            'status' => 'error',
            'message' => "Could not update project"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $deleteProject  = $this->repository->deleteProject($id);

        if ($deleteProject) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Could not delete Project.'
        ]);
    }
}

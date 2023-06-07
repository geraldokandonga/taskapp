<?php

namespace App\Repositories;

use App\Contract\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    public function getAllProjects()
    {
        return Project::all();
    }

    public function getProjectById($id)
    {
        return Project::findOrFail($id);
    }

    public function deleteProject($id)
    {
        $project = $this->getProjectById($id);

        return $project->delete();
    }

    public function createProject(array $attributes)
    {
        return Project::create($attributes);
    }

    public function updateProject($id, array $attributes)
    {

        $project = $this->getProjectById($id);

        return $project->update($attributes);
    }
}

<?php

namespace App\Contract;

interface ProjectRepositoryInterface
{
    public function getAllProjects();
    public function getProjectById($id);
    public function deleteProject($id);
    public function createProject(array $attributes);
    public function updateProject($id, array $attributes);
}

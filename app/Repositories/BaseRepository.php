<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $sortProperty = 'created_at';
    protected $sortDirection = 'DESC';
}

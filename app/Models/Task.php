<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'priority',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(User::class, 'project_id');
    }

    /**
     * Set priority value
     */
    public function setPriorityAttribute($value)
    {
        $value = intval($value);
        if ($value < 0) {
            $value = 0;
        }
        $this->attributes['priority'] = intval($value);
    }

    /**
     * Check duplication
     *
     * @return bool
     */
    public static function isDuplicated($id, $name)
    {
        $dupTask = self::where('id', '!=', $id)
            ->where('name', $name)
            ->first();

        if ($dupTask) {
            return true;
        }

        return false;
    }

    /**
     * Get task by name
     * @param $name: String
     * @return a task
     */
    public static function getTaskByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * Get all tasks
     * @return task list
     */
    public static function getAllTasks()
    {
        return self::orderBy('priority', 'asc')->get();
    }
}

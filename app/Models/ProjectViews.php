<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $number
 * @property int $project_id
 */
class ProjectViews extends Model
{
    use HasFactory;
    public $timestamps = false;

}

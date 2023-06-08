<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $canvas_link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Project extends Model
{
    use HasFactory;
}

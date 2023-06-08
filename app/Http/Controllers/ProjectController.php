<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectViews;
use Illuminate\Database\RecordsNotFoundException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('projects-list', [
            'title' => 'Projects',
            'projects' => $projects,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Project::whereId($id)->exists()) {
            throw new RecordsNotFoundException('Project not found');
        }

        $project = Project::whereId($id)->firstOrFail();
        $projectView = ProjectViews::where(['project_id' => $id])->firstOrFail();
        $hits = $projectView->number + 1;
        ProjectViews::where(['project_id' => $id])->update(['number' => $hits]);

        return view('project', [
            'title' => 'Project',
            'project' => $project,
            'hits' => $hits,
        ]);
    }
}

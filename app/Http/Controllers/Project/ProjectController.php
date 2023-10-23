<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Jobs\Project\LoadProjectJob;
use App\Jobs\Project\UpsetProjectJob;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resource\Project\ProjectResource;
use App\Transforms\Project\StoreProjectRequestTransformer;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * Loads all the projects.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = $this->dispatchSync(new LoadProjectJob());

        return ProjectResource::collection($projects);
    }


    /**
     * Stores a new project into the database.
     *
     * @param \App\Http\Requests\Project\ProjectRequest              $request
     * @param \App\Transforms\Project\StoreProjectRequestTransformer $transformer
     *
     * @return \App\Http\Resource\Project\ProjectResource
     */
    public function store(ProjectRequest $request, StoreProjectRequestTransformer $transformer): ProjectResource {
        /** @var \App\ValueObjects\Project\ProjectValueObject $obj */
        $obj = $transformer->transform($request);

        /** @var \App\Models\Project\Project $project */
        $project = $this->dispatchSync( new UpsetProjectJob($obj));

        return new ProjectResource($project);
    }
}

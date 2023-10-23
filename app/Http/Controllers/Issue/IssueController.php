<?php

namespace App\Http\Controllers\Issue;

use App\Models\Issue\Issue;
use Illuminate\Http\JsonResponse;
use App\Jobs\Issue\UpsertIssueJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\Issue\IssueRequest;
use App\Http\Resource\Issue\IssueResource;
use App\Transforms\Issue\IssueRequestTransformer;
use App\Jobs\Issue\Occurrence\StoreOccurrenceJob;
use App\Jobs\Issue\Stacktrace\StoreStacktraceJob;
use App\Transforms\Issue\Occurrence\IssueOccurrenceTransformer;
use App\Transforms\Issue\Stacktrace\IssueStacktraceTransformer;

class IssueController extends Controller
{
    /**
     * Shows an issue.
     *
     * @param \App\Models\Issue\Issue $issue
     *
     * @return \App\Http\Resource\Issue\IssueResource
     */
    public function show(Issue $issue): IssueResource {
        return new IssueResource($issue);
    }

    /**
     * Stores the issue and the related the stacktrace
     *
     * @param \App\Http\Requests\Issue\IssueRequest         $request
     * @param \App\Transforms\Issue\IssueRequestTransformer $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(IssueRequest $request, IssueRequestTransformer $transformer): JsonResponse {
        /** @var \App\ValueObjects\Issue\IssueValueObject $issueObj */
        $issueObj = $transformer->setProject($request->input('project'))
                                ->transform($request);

        $issue = $this->dispatchSync(new UpsertIssueJob($issueObj));
        /** @var \App\ValueObjects\Issue\OccurrenceValueObject $occurrenceObj */
        $occurrenceObj = (new IssueOccurrenceTransformer())
            ->setIssue($issue)
            ->transform($request);

        $occurrence = $this->dispatchSync(new StoreOccurrenceJob($occurrenceObj));

        /** @var \App\ValueObjects\Issue\StacktraceValueObject $stacktraceObj */
        $stacktraceObj = (new IssueStacktraceTransformer())
            ->setOccurrence($occurrence)
            ->transform($request);

        $this->dispatchSync(new StoreStacktraceJob($stacktraceObj));

        return response()->json([], 200);
    }
}

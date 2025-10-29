<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Issue\IssueResource;
use App\Http\Resources\Issue\IssueShortResource;
use App\Http\Resources\Issue\IssueCommentResource;
use App\Http\Requests\Issue\CreateIssueRequest;
use App\Http\Requests\Issue\UpdateIssueRequest;
use App\Http\Requests\Issue\CreateIssueCommentRequest;
use App\Models\Issue;
use App\Facades\IssueServiceFacade as IssueService;
use App\Models\IssueComment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class IssueController
 *
 * Controller for managing issues and comments to them.
 */
class IssueController extends Controller
{

    /**
     * Get a list of issues with pagination.
     *
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $issues = Issue::filter($request->query());
        return IssueShortResource::collection($issues->paginate(config('pagination.per_page')));
    }

    /**
     * Get information about a specific issue.
     *
     * @param Issue $issue Issue model
     * @return IssueResource
     */
    public function show(Issue $issue): IssueResource
    {
        return new IssueResource($issue);
    }

    /**
     * Create a new issue.
     *
     * @param CreateIssueRequest $request
     * @return IssueResource
     */
    public function store(CreateIssueRequest $request): IssueResource
    {
        return new IssueResource(IssueService::store($request->getDto()));
    }

    /**
     * Update issue information.
     *
     * @param Issue $issue Issue model
     * @param UpdateIssueRequest $request
     * @return IssueResource
     */
    public function update(Issue $issue, UpdateIssueRequest $request): IssueResource
    {
        return new IssueResource(IssueService::setIssue($issue)->update($request->getDto()));
    }

    /**
     * Delete an issue.
     *
     * @param Issue $issue Issue model
     * @return JsonResponse
     */
    public function destroy(Issue $issue): JsonResponse
    {
        IssueService::setIssue($issue)->delete();

        return responseOk();
    }

    /**
     * Add a comment to an issue.
     *
     * @param Issue $issue Issue model
     * @param CreateIssueCommentRequest $request
     * @return IssueCommentResource
     */
    public function storeComment(Issue $issue, CreateIssueCommentRequest $request): IssueCommentResource
    {
        return new IssueCommentResource(IssueService::setIssue($issue)->storeComment($request->getDto()));
    }

    /**
     * Delete a comment to an issue.
     *
     * @param IssueComment $issueComment Comment model
     * @return JsonResponse
     */
    public function destroyComment(IssueComment $issueComment): JsonResponse
    {
        IssueService::deleteComment($issueComment);

        return responseOk();
    }
}

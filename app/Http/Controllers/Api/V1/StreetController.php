<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Address\StreetResource;
use App\Models\Street;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Address\UpdateStreetRequest;
use App\Http\Requests\Address\CreateStreetRequest;
use App\Exceptions\ModelHasChildRecordsException;

/**
 * Class StreetController
 *
 * Controller for managing street list via API
 */
class StreetController extends Controller
{

    /**
     * Gets a list of streets with pagination.
     *
     * @return JsonResource  Collection of street resources
     */
    public function index(Request $request): JsonResource
    {
        $streets = Street::filter($request->query());
        return StreetResource::collection($streets->paginate(config('pagination.per_page')));
    }

    /**
     * Gets information about a specific street.
     *
     * @param  Street  $street  Street model
     * @return StreetResource   Street resource
     */
    public function show(Street $street): StreetResource
    {
        return new StreetResource($street);
    }

    /**
     * Creates a new street.
     *
     * @param  CreateStreetRequest $request
     * @return StreetResource     Resource of the created street
     */
    public function store(CreateStreetRequest $request): StreetResource
    {
        return new StreetResource(Street::create($request->getDto()->toArray()));
    }

    /**
     * Updates street information.
     *
     * @param  Street      $street  Street model to update
     * @param  UpdateStreetRequest $request
     * @return StreetResource       Resource of the updated street
     */
    public function update(Street $street, UpdateStreetRequest $request): StreetResource
    {
        $street->fill($request->getDto()->toArray())->save();
        return new StreetResource($street->load('location'));
    }

    /**
     * Deletes a street.
     *
     * @param  Street  $street  Street model to delete
     * @return JsonResponse     Response about successful deletion
     */
    public function destroy(Street $street): JsonResponse
    {
        try {
            $street->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('streets.street_have_address'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return responseOk();
    }
}

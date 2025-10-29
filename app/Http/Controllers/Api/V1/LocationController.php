<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Location;
use App\Http\Resources\Address\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Address\LocationRequest;
use App\Exceptions\ModelHasChildRecordsException;

/**
 * Class LocationController
 *
 * Controller for managing locations via API
 */
class LocationController extends Controller
{

    /**
     * Get a list of locations with pagination
     *
     * @return JsonResource Collection of location resources
     */
    public function index(): JsonResource
    {
        return LocationResource::collection(Location::paginate(config('pagination.per_page')));
    }

    /**
     * Get information about a specific location
     *
     * @param Location $location Location model
     * @return LocationResource Location resource
     */
    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);
    }

    /**
     * Create a new location
     *
     * @param LocationRequest $request
     * @return LocationResource Resource of the created location
     */
    public function store(LocationRequest $request): LocationResource
    {
        return new LocationResource(Location::create($request->getDto()->toArray()));
    }

    /**
     * Update location information
     *
     * @param Location $location Location model to update
     * @param LocationRequest $request
     * @return LocationResource Resource of the updated location
     */
    public function update(Location $location, LocationRequest $request): LocationResource
    {
        $location->fill($request->getDto()->toArray())->save();
        return new LocationResource($location);
    }

    /**
     * Delete a location
     *
     * @param Location $location Location model to delete
     * @return JsonResponse Response about successful deletion
     */
    public function destroy(Location $location): JsonResponse
    {
        try {
            $location->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('locations.location_have_streets'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return responseOk();
    }
}

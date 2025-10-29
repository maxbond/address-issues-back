<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Address;
use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Exceptions\ModelHasChildRecordsException;

/**
 * Class AddressController
 *
 * Controller for managing addresses via API
 */
class AddressController extends Controller
{
    /**
     * Get a list of addresses with pagination
     *
     * @return JsonResource Collection of address resources
     */
    public function index(Request $request): JsonResource
    {
        $addresses = Address::filter($request->query());
        return AddressResource::collection($addresses->paginate(config('pagination.per_page')));
    }

    /**
     * Get address information
     *
     * @param Address $address Address model
     * @return AddressResource Address resource
     */
    public function show(Address $address): AddressResource
    {
        return new AddressResource($address);
    }

    /**
     * Create a new address
     *
     * @param CreateAddressRequest $request
     * @return AddressResource Resource of the created address
     */
    public function store(CreateAddressRequest $request): AddressResource
    {
        return new AddressResource(Address::create($request->getDto()->toArray()));
    }

    /**
     * Update address information
     *
     * @param Address $address Address model to update
     * @param UpdateAddressRequest $request
     * @return AddressResource Resource of the updated address
     */
    public function update(Address $address, UpdateAddressRequest $request): AddressResource
    {
        $address->fill($request->getDto()->toArray())->save();
        return new AddressResource($address->load('street'));
    }

    /**
     * Delete an address
     *
     * @param Address $address Address model to delete
     * @return JsonResponse Response about successful deletion
     */
    public function destroy(Address $address): JsonResponse
    {
        try {
            $address->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('address.address_have_issues'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return responseOk();
    }
}

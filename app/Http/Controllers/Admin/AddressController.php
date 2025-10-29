<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Street;
use App\Models\Address;
use App\Http\Requests\Address\CreateAddressRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Exceptions\ModelHasChildRecordsException;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = Address::filter($request->query());
        return view('admin.addresses.index', ['addresses' => $addresses->paginate(config('pagination.per_page'))]);
    }

    /**
     * Create address form
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.addresses.create', ['streets' => Street::all()]);
    }

    /**
     * Edit address form
     *
     * @param Address $address
     * @return View
     */
    public function edit(Address $address): View
    {
        return view('admin.addresses.edit', ['address' => $address, 'streets' => Street::all()]);
    }

    /**
     * Create a new address
     *
     * @param CreateAddressRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAddressRequest $request): RedirectResponse
    {
        Address::create($request->validated());
        return redirect(route('admin.addresses.index'));
    }

    /**
     * Update address
     *
     * @param CreateAddressRequest $request
     * @param Address $address
     * @return RedirectResponse
     */
    public function update(CreateAddressRequest $request, Address $address): RedirectResponse
    {
        $address->fill($request->validated())->save();
        return redirect(route('admin.addresses.index'));
    }

    /**
     * Delete address
     *
     * @param Address $address
     * @return RedirectResponse
     */
    public function destroy(Address $address): RedirectResponse
    {
        try {
            $address->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('address.address_have_issues'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return redirect(route('admin.addresses.index'));
    }
}

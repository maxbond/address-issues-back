<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Http\Requests\Address\LocationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Exceptions\ModelHasChildRecordsException;

class LocationController extends Controller
{
    public function index(): View
    {
        return view('admin.locations.index', ['locations' => Location::paginate(config('pagination.per_page'))]);
    }

    /**
     * Create location form
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.locations.create');
    }

    /**
     * Edit location form
     *
     * @param Location $location
     * @return View
     */
    public function edit(Location $location): View
    {
        return view('admin.locations.edit', ['location' => $location]);
    }

    /**
     * Create a new location
     *
     * @param LocationRequest $request
     * @return RedirectResponse
     */
    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());
        return redirect(route('admin.locations.index'));
    }

    /**
     * Update location
     *
     * @param LocationRequest $request
     * @param Location $location
     * @return RedirectResponse
     */
    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->fill($request->validated())->save();
        return redirect(route('admin.locations.index'));
    }

    /**
     * Delete location
     *
     * @param Location $location
     * @return RedirectResponse
     */
    public function destroy(Location $location): RedirectResponse
    {
        try {
            $location->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('locations.location_have_streets'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return redirect(route('admin.locations.index'));
    }
}

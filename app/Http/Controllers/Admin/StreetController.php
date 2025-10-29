<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Street;
use App\Models\Location;
use App\Http\Requests\Address\CreateStreetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Exceptions\ModelHasChildRecordsException;

class StreetController extends Controller
{
    public function index(): View
    {
        return view('admin.streets.index', ['streets' => Street::paginate(config('pagination.per_page'))]);
    }

    /**
     * Create street form
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.streets.create', ['locations' => Location::all()]);
    }

    /**
     * Edit street form
     *
     * @param Street $street
     * @return View
     */
    public function edit(Street $street): View
    {
        return view('admin.streets.edit', ['street' => $street, 'locations' => Location::all()]);
    }

    /**
     * Create a new street
     *
     * @param CreateStreetRequest $request
     * @return RedirectResponse
     */
    public function store(CreateStreetRequest $request): RedirectResponse
    {
        Street::create($request->validated());
        return redirect(route('admin.streets.index'));
    }

    /**
     * Update street
     *
     * @param CreateStreetRequest $request
     * @param Street $street
     * @return RedirectResponse
     */
    public function update(CreateStreetRequest $request, Street $street): RedirectResponse
    {
        $street->fill($request->validated())->save();
        return redirect(route('admin.streets.index'));
    }

    /**
     * Delete street
     *
     * @param Street $street
     * @return RedirectResponse
     */
    public function destroy(Street $street): RedirectResponse
    {
        try {
            $street->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw new ModelHasChildRecordsException(__('streets.street_have_address'));
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return redirect(route('admin.streets.index'));
    }
}

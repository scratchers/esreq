<?php

namespace App\Http\Controllers;

use App\Institution;
use Illuminate\Http\Request;
use App\Http\Requests\InstitutionRequest;
use App\GoogleMaps;

class InstitutionController extends Controller
{
    protected $gmaps;

    public function __construct(GoogleMaps $gmaps)
    {
        $this->gmaps = $gmaps;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = Institution::all();

        if (requestExpectsJson()) {
            return $institutions;
        }

        return view('institutions.index', ['institutions' => $institutions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('institution_id')) {
            session(['institution_id' => $request->institution_id]);
            return redirect('/register');
        }

        if ($request->has('institution')) {
            $location = $this->gmaps->queryLatLng($request->institution);

            return view('institutions.create', [
                'name' => $request->institution,
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
            ]);
        }

        return view('institutions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InstitutionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitutionRequest $request)
    {
        $institution = Institution::create($request->all());

        if (is_null($request->user())) {
            session(['institution_id' => $institution->id]);
            return redirect('/register');
        }

        return redirect(route('institutions.show', $institution));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        if (requestExpectsJson()) {
            return $institution;
        }

        return view('institutions.show', ['institution' => $institution]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Institution $institution)
    {
        return view('institutions.edit', ['institution' => $institution]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institution $institution)
    {
        if ($institution->update($request->all())) {
            return redirect(route('institutions.show', $institution));
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institution $institution)
    {
        //
    }
}

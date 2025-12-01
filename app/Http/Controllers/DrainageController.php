<?php

namespace App\Http\Controllers;

use App\Models\Drainage;
use App\Models\OfficeRoad;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DrainageController extends Controller
{
    public function datatables()
    {
        $query = Drainage::query();
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($item) {
            return '<a href="' . route('data.show', $item['id']) . '" class="btn btn-warning">Detail</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function maps()
    {
        $file = public_path('maps/Drainase_B2_Olah_R2.shp.kmz');
        return response()->file($file, [
            'Content-Type' => 'application/vnd.google-earth.kmz'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($drainage)
    {
        $officeRoad = OfficeRoad::where('drainage_id', $drainage)->get();
        return view('detail-data', compact('officeRoad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drainage $drainage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drainage $drainage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drainage $drainage)
    {
        //
    }
}

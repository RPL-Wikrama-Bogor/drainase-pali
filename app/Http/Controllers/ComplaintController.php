<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::all();
        return view('pengaduan', compact('complaints'));
    }

    public function datatables()
    {
        $query = Complaint::query();
        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('imgSrc', function($item) {
            return '<img src="' . asset('assets/') . $item['image'] . '" width="150">';
        })
        ->editColumn('status', function($item) {
            return '<span class="badge badge-success">' . $item['status'] . '</span>';
        })
        ->editColumn('date', function($item) {
            return Carbon::parse($item->date)->format('d F, Y');
        })
        ->rawColumns(['imgSrc', 'status'])
        ->make('true');
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
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}

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
        $path = public_path("maps/drainase.json");
        $json = json_decode(file_get_contents($path), true);

        $features = $json['features'];

        // Group berdasarkan nama ruas
        $grouped = collect($features)->groupBy(function ($f) {
            return $f['properties']['NAMA_RUAS'] ?: "TANPA NAMA";
        });

        // Format data
        $rows = $grouped->map(function ($items, $ruasName) {

            $first = $items->first()['properties'];

            $safeName = $ruasName ?: 'TANPA NAMA';
            $encoded  = rawurlencode($safeName);

            return [
                "nama_ruas"          => $safeName,
                "fungsi_jalan"       => $first['FUNGSI_JLN'] ?? '-',
                "panjang_sk_km"      => $first['PANJANG_KM'] ?? 0,
                "panjang_kajian_km"  => round($items->sum(fn($i) => $i['properties']['PANJANG_KM'] ?? 0), 3),
                "panjang_kajian_m"   => round($items->sum(fn($i) => $i['properties']['PANJANG_M'] ?? 0), 2),

                "action"             => '<a href="' . route('data.show', $encoded) . '" class="btn btn-primary btn-sm">Detail</a>'
            ];
        })->values();

        return response()->json([
            "data" => $rows
        ]);
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
    public function show($ruasName)
    {
        $ruasName = urldecode($ruasName);

        $path = public_path("maps/drainase.json");
        $json = json_decode(file_get_contents($path), true);

        // Ambil semua fitur berdasarkan nama ruas
        $features = collect($json['features'])
            ->filter(fn($f) => $f['properties']['NAMA_RUAS'] == $ruasName)
            ->values();

        // Kirim seluruh features untuk Leaflet
        return view("detail-data", [
            "ruasName" => $ruasName,
            "segments" => $features,
            "geojson"  => $features->map(fn($f) => [
                "type" => "Feature",
                "geometry" => $f["geometry"],
                "properties" => $f["properties"]
            ])
        ]);
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

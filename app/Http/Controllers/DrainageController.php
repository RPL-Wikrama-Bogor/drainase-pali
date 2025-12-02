<?php

namespace App\Http\Controllers;

use App\Models\Drainage;
use App\Models\DrainaseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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

    public function index(Request $request)
    {
        // Load data dari JSON file
        $jsonPath = public_path("maps/drainase.json");

        if (!file_exists($jsonPath)) {
            return back()->with('error', 'File drainase.json tidak ditemukan!');
        }

        $jsonContent = file_get_contents($jsonPath);
        $drainaseData = json_decode($jsonContent, true);

        if (!$drainaseData || !isset($drainaseData['features'])) {
            return back()->with('error', 'Format JSON tidak valid!');
        }

        $features = collect($drainaseData['features'] ?? []);

        // Load gambar dari database
        $images = DrainaseImage::all()->keyBy('identifier');

        return view('admin.drainage.index', compact('features', 'images'));
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'nama_ruas' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate nama file yang unik
        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $filename = Str::slug($request->nama_ruas) . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // Tentukan path folder
        $folderPath = 'drainase/' . date('Y') . '/' . date('m');

        // Simpan gambar ke storage
        $path = $image->storeAs($folderPath, $filename, 'public');

        // Jika penyimpanan gagal
        if (!$path) {
            throw new \Exception('Gagal menyimpan gambar ke storage');
        }

        // Simpan atau update data gambar ke database
        $drainaseImage = DrainaseImage::updateOrCreate(
            ['identifier' => $request->identifier],
            [
                'nama_ruas' => $request->nama_ruas,
                'filename' => $filename,
                'path' => $path,
                'original_name' => $originalName,
                'mime_type' => $image->getMimeType(),
                'size' => $image->getSize(),
                'description' => $request->description
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil diupload!',
            'data' => [
                'id' => $drainaseImage->id,
                'image_url' => $drainaseImage->image_url,
                'filename' => $drainaseImage->filename
            ]
        ]);
    }

    public function updateImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $drainaseImage = DrainaseImage::findOrFail($id);
        $image = $request->file('image');

        // Hapus gambar lama jika ada
        if ($drainaseImage->path && Storage::disk('public')->exists($drainaseImage->path)) {
            Storage::disk('public')->delete($drainaseImage->path);
        }

        // Generate nama file baru
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $filename = Str::slug($drainaseImage->nama_ruas) . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        // Gunakan path folder yang sama
        $folderPath = dirname($drainaseImage->path);
        $path = $image->storeAs($folderPath, $filename, 'public');

        // Update data gambar di database
        $drainaseImage->update([
            'filename' => $filename,
            'path' => $path,
            'original_name' => $originalName,
            'mime_type' => $image->getMimeType(),
            'size' => $image->getSize(),
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil diupdate!',
            'data' => [
                'image_url' => $drainaseImage->image_url,
                'filename' => $drainaseImage->filename
            ]
        ]);
    }

    public function deleteImage($id)
    {
        $drainaseImage = DrainaseImage::findOrFail($id);

        // Hapus file dari storage
        if ($drainaseImage->path && Storage::disk('public')->exists($drainaseImage->path)) {
            Storage::disk('public')->delete($drainaseImage->path);
        }

        $drainaseImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus!'
        ]);
    }

    public function showImage($id)
    {
        $drainaseImage = DrainaseImage::findOrFail($id);

        if (!$drainaseImage->imageExists()) {
            abort(404, 'Gambar tidak ditemukan');
        }

        return response()->file($drainaseImage->storage_path);
    }

    public function downloadImage($id)
    {
        $drainaseImage = DrainaseImage::findOrFail($id);

        if (!Storage::disk('public')->exists($drainaseImage->path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($drainaseImage->path, $drainaseImage->original_name);
    }

    /**
     * Display a listing of the resource.
     */
    public function datatablesAdmin()
    {
        $path = public_path("maps/drainase.json");

        // Error handling untuk file
        if (!file_exists($path)) {
            return response()->json([
                "data" => [],
                "error" => "File drainase.json tidak ditemukan"
            ]);
        }

        $content = file_get_contents($path);
        $json = json_decode($content, true);

        // Error handling untuk JSON decode
        if ($json === null) {
            return response()->json([
                "data" => [],
                "error" => "Format JSON tidak valid: " . json_last_error_msg()
            ]);
        }

        // Pastikan features ada
        if (!isset($json['features']) || !is_array($json['features'])) {
            return response()->json([
                "data" => [],
                "error" => "Struktur GeoJSON tidak valid"
            ]);
        }

        // Kelompokkan data berdasarkan NAMA_RUAS
        $groupedData = [];
        foreach ($json['features'] as $feature) {
            $ruasName = $feature['properties']['NAMA_RUAS'] ?? 'TANPA NAMA';

            if (!isset($groupedData[$ruasName])) {
                $groupedData[$ruasName] = [];
            }

            $groupedData[$ruasName][] = $feature;
        }

        // Format data untuk datatable
        $rows = [];
        foreach ($groupedData as $ruasName => $features) {
            if (empty($features)) continue;

            $firstFeature = $features[0];
            $firstProperties = $firstFeature['properties'] ?? [];

            // Hitung total panjang
            $totalPanjangKm = 0;
            $totalPanjangM = 0;
            foreach ($features as $feature) {
                $totalPanjangKm += $feature['properties']['PANJANG_KM'] ?? 0;
                $totalPanjangM += $feature['properties']['PANJANG_M'] ?? 0;
            }

            $safeName = $ruasName ?: 'TANPA NAMA';
            $encoded = rawurlencode($safeName);

            $rows[] = [
                "DT_RowId" => "row_" . md5($safeName), // ID unik untuk setiap row
                "nama_ruas" => $safeName,
                "fungsi_jalan" => $firstProperties['FUNGSI_JLN'] ?? '-',
                "status_jalan" => $firstProperties['STATUS_JLN'] ?? '-',
                "panjang_sk_km" => $firstProperties['PANJANG_KM'] ?? 0,
                "panjang_kajian_km" => round($totalPanjangKm, 3),
                "panjang_kajian_m" => round($totalPanjangM, 2),
                "jumlah_segmen" => count($features),
                "action" => '<div class="btn-group" role="group">
                    <a href="' . route('data.show', $encoded) . '" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <button type="button" class="btn btn-info btn-sm view-map" data-ruas="' . htmlspecialchars($safeName) . '">
                        <i class="fas fa-map"></i> Peta
                    </button>
                </div>'
            ];
        }

        return response()->json([
            "draw" => request()->input('draw', 1),
            "recordsTotal" => count($rows),
            "recordsFiltered" => count($rows),
            "data" => $rows
        ]);
    }

    public function maps()
    {
        $file = public_path('maps/Drainase_B2_Olah_R2.shp.kmz');
        return response()->file($file, [
            'Content-Type' => 'application/vnd.google-earth.kmz'
        ]);
    }

    public function getImages()
    {
        $images = DrainaseImage::all()->map(function($image) {
            return [
                'identifier' => $image->identifier,
                'image_url' => $image->image_url,
                'description' => $image->description,
                'original_name' => $image->original_name
            ];
        });

        return response()->json($images);
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

    public function importProcess(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'geojson_file' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    $allowedExtensions = ['json', 'geojson'];
                    $originalName = $value->getClientOriginalName();
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);

                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        $fail('File harus berekstensi .json atau .geojon. File Anda: .' . $extension);
                    }
                }
            ],
            'create_backup' => 'nullable|boolean',
            'validate_json' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.drainase.import')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('geojson_file');
            $createBackup = $request->boolean('create_backup', true);
            $validateJson = $request->boolean('validate_json', true);

            // Path target
            $targetPath = public_path('maps');
            $targetFile = $targetPath . '/drainase.json';

            // Buat folder maps jika belum ada
            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0755, true);
            }

            // Validasi struktur JSON jika diperlukan
            if ($validateJson) {
                $jsonContent = file_get_contents($file->getRealPath());
                $parsedJson = json_decode($jsonContent, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('File bukan JSON yang valid. Error: ' . json_last_error_msg());
                }

                // Validasi struktur GeoJSON dasar
                if (!isset($parsedJson['type']) || $parsedJson['type'] !== 'FeatureCollection') {
                    throw new \Exception('Struktur GeoJSON tidak valid. Harus memiliki "type": "FeatureCollection"');
                }

                if (!isset($parsedJson['features']) || !is_array($parsedJson['features'])) {
                    throw new \Exception('Struktur GeoJSON tidak valid. Harus memiliki "features" array');
                }

                // Validasi setiap feature
                $validFeatures = 0;
                foreach ($parsedJson['features'] as $index => $feature) {
                    if (!isset($feature['type']) || $feature['type'] !== 'Feature') {
                        throw new \Exception("Feature #{$index} tidak valid: harus memiliki 'type': 'Feature'");
                    }

                    if (!isset($feature['geometry'])) {
                        throw new \Exception("Feature #{$index} tidak valid: harus memiliki 'geometry'");
                    }

                    if (!isset($feature['properties'])) {
                        throw new \Exception("Feature #{$index} tidak valid: harus memiliki 'properties'");
                    }

                    $validFeatures++;
                }

                if ($validFeatures === 0) {
                    throw new \Exception('Tidak ada fitur yang valid dalam file!');
                }
            }

             // Buat backup file lama jika ada dan diminta
            if ($createBackup && File::exists($targetFile)) {
                $backupName = 'drainase_backup_' . date('Ymd_His') . '.json';
                File::copy($targetFile, $targetPath . '/' . $backupName);
            }

            // Simpan file baru
            $file->move($targetPath, 'drainase.json');

            // Set permission file
            chmod($targetFile, 0644);

            // Hitung statistik
            $jsonContent = file_get_contents($targetFile);
            $parsedJson = json_decode($jsonContent, true);
            $featureCount = count($parsedJson['features'] ?? []);

            return redirect()->route('admin.drainase.import')
                ->with('success', "Data drainase berhasil diimport! {$featureCount} fitur telah diproses.");

        } catch (\Exception $e) {
            return redirect()->route('admin.drainase.import')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage())
                ->withInput();
        }
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

        // Load semua gambar dari database
        $allImages = DrainaseImage::all();
        $images = collect();

        // Mapping identifier dengan prioritas
        foreach ($allImages as $image) {
            $identifier = trim($image->identifier);

            // Coba match dengan SEGMEN terlebih dahulu
            $matchingSegment = $features->first(function($f) use ($identifier) {
                $props = $f['properties'];
                $segmentId = $props['SEGMEN'] ?? '';
                $namaRuas = $props['NAMA_RUAS'] ?? '';

                // Cek apakah identifier cocok dengan SEGMEN
                if ($segmentId && trim($segmentId) == $identifier) {
                    return true;
                }

                // Cek apakah identifier cocok dengan NAMA_RUAS
                if ($namaRuas && trim($namaRuas) == $identifier) {
                    return true;
                }

                return false;
            });

            if ($matchingSegment) {
                $props = $matchingSegment['properties'];
                $key = $props['SEGMEN'] ?? $props['NAMA_RUAS'] ?? 'unknown';
                $images->put($key, $image);
            }
        }

        return view("detail-data", [
            "images" => $images,
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

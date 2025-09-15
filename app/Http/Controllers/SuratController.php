<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('kategori');
        
        if ($request->has('search') && !empty($request->search)) {
            $query->where('judul', 'LIKE', '%' . $request->search . '%');
        }
        
        $surats = $query->orderBy('waktu_pengarsipan', 'desc')->get();
        
        return view('surat.index', compact('surats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('surat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|unique:surats',
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required',
            'file' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Bersihkan nama file original dari karakter ilegal
            $originalName = $file->getClientOriginalName();
            $cleanOriginalName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $originalName);
            
            $filename = time() . '_' . $cleanOriginalName;
            $path = $file->storeAs('surat-files', $filename, 'public');

            Surat::create([
                'nomor_surat' => $request->nomor_surat,
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'file_path' => $path,
                'waktu_pengarsipan' => now(),
            ]);

            return redirect()->route('surat.index')->with('success', 'Data berhasil disimpan');
        }

        return back()->with('error', 'Gagal mengupload file!');
    }

    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    public function destroy(Surat $surat)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($surat->file_path)) {
            Storage::disk('public')->delete($surat->file_path);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus!');
    }

    public function download(Surat $surat)
    {
        $filePath = storage_path('app/public/' . $surat->file_path);
        
        if (file_exists($filePath)) {
            // Bersihkan nama file dari karakter yang tidak valid
            $cleanFileName = preg_replace('/[\/\\\\:*?"<>|]/', '_', $surat->nomor_surat);
            $downloadName = $cleanFileName . '.pdf';
            
            return response()->download($filePath, $downloadName);
        }

        return back()->with('error', 'File tidak ditemukan!');
    }

    public function preview($id)
    {
        $surat = Surat::findOrFail($id);
        
        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            abort(404, 'File PDF tidak ditemukan');
        }
        
        $fileContents = Storage::disk('public')->get($surat->file_path);
        $fileName = basename($surat->file_path);
        
        return response($fileContents)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"')
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('Accept-Ranges', 'bytes');
    }

    public function previewSecure($id)
    {
        $surat = Surat::findOrFail($id);
        
        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            abort(404, 'File PDF tidak ditemukan');
        }
        
        $fileContents = Storage::disk('public')->get($surat->file_path);
        $fileName = basename($surat->file_path);
        
        return response($fileContents)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->header('X-Content-Type-Options', 'nosniff')
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('Content-Security-Policy', "object-src 'self' blob: data:");
    }

    public function previewDataUri($id)
    {
        $surat = Surat::findOrFail($id);
        
        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        
        $fileContents = Storage::disk('public')->get($surat->file_path);
        $base64 = base64_encode($fileContents);
        $dataUri = 'data:application/pdf;base64,' . $base64;
        
        return response()->json([
            'dataUri' => $dataUri,
            'filename' => basename($surat->file_path)
        ]);
    }
}

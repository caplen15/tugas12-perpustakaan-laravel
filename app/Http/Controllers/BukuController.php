<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
 
class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        $filterOptions = $this->getFilterOptions();

        // Return view dengan data
        return view('buku.index', array_merge(
            compact(
                'bukus',
                'totalBuku',
                'bukuTersedia',
                'bukuHabis'
            ),
            $filterOptions
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($query) use ($keyword) {
                $query->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan === 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan === 'habis') {
                $query->where('stok', 0);
            }
        }

        $bukus = $query->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $filterOptions = $this->getFilterOptions();

        return view('buku.index', array_merge(
            compact('bukus', 'totalBuku', 'bukuTersedia', 'bukuHabis'),
            $filterOptions
        ))->with([
            'kategori' => $request->kategori,
            'keyword' => $request->keyword,
            'tahun' => $request->tahun,
            'ketersediaan' => $request->ketersediaan,
        ]);
    }

    // public function create()
    // {
    //     // Akan diimplementasi di pertemuan 12
    //     return view('buku.create');
    // }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
        // Create buku baru dengan validated data
        Buku::create($request->validated());
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil ditambahkan!');
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
    }
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find buku by ID, throw 404 if not found
        $buku = Buku::findOrFail($id);
        
        // Return view detail buku
        return view('buku.show', compact('buku'));
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
        $buku = Buku::findOrFail($id);
        
        // Update buku dengan validated data
        $buku->update($request->validated());
        
        // Redirect dengan success message
        return redirect()->route('buku.show', $buku->id)
                         ->with('success', 'Buku berhasil diupdate!');
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
    }
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
        $buku = Buku::findOrFail($id);
        $judulBuku = $buku->judul;
        
        // Delete buku
        $buku->delete();
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
    }
    
    /**
     * Filter buku berdasarkan kategori.
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();
        
        return view('buku.index', array_merge(
            compact(
                'bukus',
                'totalBuku',
                'bukuTersedia',
                'bukuHabis',
                'kategori'
            ),
            $this->getFilterOptions()
        ));
    }

    private function getFilterOptions(): array
    {
        $kategoriList = Kategori::orderBy('nama_kategori')->pluck('nama_kategori')->toArray();

        if (empty($kategoriList)) {
            $kategoriList = Buku::select('kategori')
                ->distinct()
                ->orderBy('kategori')
                ->pluck('kategori')
                ->toArray();
        }

        $tahunList = Buku::select('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit')
            ->toArray();

        return compact('kategoriList', 'tahunList');
    }

    public function create()
    {
        return view('buku.create');
    }
}

# Tugas 5 - Book Sales API
**Nama:** Fatkur Rohman Irham  
**Kampus:** Politeknik Negeri Banyuwangi  

Proyek ini merupakan bagian dari tugas pembuatan API untuk sistem penjualan buku menggunakan Laravel. Pada tugas ini, fokus utamanya adalah melengkapi operasi CRUD dan mengoptimalkan penulisan kode routing.

## Instruksi Tugas

1. **Lengkapi Fitur CRUD:** 
   - Membuat fungsi `Show` (detail), `Update` (ubah), dan `Destroy` (hapus) untuk tabel **Genre** dan **Author**.
2. **Validasi Data Tidak Ditemukan:** 
   - Memberikan respon yang tepat (seperti 404 Not Found) ketika data yang dicari, diubah, atau dihapus tidak ada di dalam database.
3. **Optimisasi Routing:** 
   - Mengubah deklarasi rute di `routes/api.php` dengan menggunakan metode `Route::apiResource`.

---

## Hasil Pengerjaan Tugas

### Bagian 1: Show, Update, Destroy pada Tabel Genre

#### A. Kode Implementasi (`GenreController.php`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
   public function index()
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "No data found",
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "get ALL Resource",
            "data" => $genres
        ],200);
    }
    public function show(string $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'get detail resource',
            'data' => $genre,
        ], 200);
    }

    public function update(string $id, Request $request)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $genre->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $genre
        ], 200);
    }

    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'DELETE data resource'
        ], 200);
    }
    public function store(Request $request)
    {
        // 1. validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 2. check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. insert data
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 4. response
        return response()->json([
            'success' => true,
            'message' => 'resource added successfully!',
            'data' => $genre
        ], 201);
    }
}

```

#### B. Screenshot Pengujian Endpoint Genre

**1. Show Genre (GET)**
<img width="723" height="432" alt="image" src="https://github.com/user-attachments/assets/a1cfe8e8-91b8-4eee-8609-7f61bf51e652" />
**2. Update Genre (PUT/PATCH)**
<img width="723" height="366" alt="image" src="https://github.com/user-attachments/assets/a39d2227-b047-49b9-89bd-24b3783bcd24" />

**3. Destroy Genre (DELETE)**
<img width="718" height="353" alt="image" src="https://github.com/user-attachments/assets/78780dc7-ac23-4a56-9499-2cd4eaa4bb11" />


---

### Bagian 2: Show, Update, Destroy pada Tabel Author

#### A. Kode Implementasi (`AuthorController.php`)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
   public function index()
    {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "No data found",
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "get ALL Resource",
            "data" => $authors
        ],200);
    }
    public function store(Request $request)
    {
        // 1. validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048', 
        ]);

        // 2. check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. upload image (photo)
        $image = $request->file('photo');
        $image->store('authors', 'public');

        // 4. insert data
        $author = Author::create([
            'name' => $request->name,
            'bio' => $request->bio,
            'photo' => $image->hashName(),
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'resource added successfully!',
            'data' => $author
        ], 201);
    }
    public function show(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'get detail resource',
            'data' => $author,
        ], 200);
    }

    public function update(string $id, Request $request)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
        ];

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->store('authors', 'public');
            if ($author->photo) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }
            $data['photo'] = $image->hashName();
        }

        $author->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $author
        ], 200);
    }

    public function destroy(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }
        if ($author->photo) {
            Storage::disk('public')->delete('authors/' . $author->photo);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'DELETE data resource'
        ], 200);
    }
}

```

#### B. Screenshot Pengujian Endpoint Author

**1. Show Author (GET)**
<img width="711" height="416" alt="image" src="https://github.com/user-attachments/assets/72dedef6-55c0-42c1-9649-723d5dd7b5cb" />


**2. Update Author (PUT/PATCH)**
<img width="724" height="383" alt="image" src="https://github.com/user-attachments/assets/44c23958-d2cf-469c-8a51-1dcbea2b8e87" />


**3. Destroy Author (DELETE)**
<img width="725" height="320" alt="image" src="https://github.com/user-attachments/assets/f06fa226-3eb5-4178-b295-126f03749243" />


---

### Bagian 3: Validasi Data Tidak Ditemukan (Not Found)

Pada bagian ini, pastikan endpoint mengembalikan respon error yang informatif (misal "Data tidak ditemukan") beserta HTTP Status Code `404 Not Found`.

**1. Data Genre Tidak Ditemukan**
<img width="716" height="293" alt="image" src="https://github.com/user-attachments/assets/e23953d8-3213-47e6-97fc-ce813b58caf8" />


**2. Data Author Tidak Ditemukan**
<img width="722" height="353" alt="image" src="https://github.com/user-attachments/assets/376a3168-f7ac-4f52-83b1-7be2de33142d" />

---

### Bagian 4: Penggunaan Route `apiResource`

#### A. Konfigurasi Endpoint (`routes/api.php`)

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('/books', BookController::class);
Route::apiResource('/author', AuthorController::class);
Route::apiResource('/genre',GenreController::class);
```

#### B. Hasil Route List
<img width="908" height="389" alt="Screenshot 2026-04-27 091640" src="https://github.com/user-attachments/assets/1b5aa06c-c207-4b8e-a1c7-2ea3e625808b" />



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
   public function index()
    {
        $books = Book::with(['author', 'genre'])->get();

        if ($books->isEmpty()){
             return response()->json([
            "success" => true,
            "message" => "not data",
        ],);
        }
        return response()->json([
            "success" => true,
            "message" => "get ALL Resource",
            "data" => $books
        ],200);
    }
    public function store(Request $request) {
    // 1. validator
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:100',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        'genre_id' => 'required|exists:genres,id',
        'author_id' => 'required|exists:authors,id'
    ]);

    // 2. check validator error
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()
        ], 422);
    }

    // 3. upload image
    $image = $request->file('cover_photo');
    $image->store('books', 'public');

    // 4. insert data
    $book = Book::create([
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'cover_photo' => $image->hashName(),
        'genre_id' => $request->genre_id,
        'author_id' => $request->author_id,
    ]);

    // 5. response
    return response()->json([
        'success' => true,
        'message' => 'Resource added successfully!',
        'data' => $book
    ], 201);
}
public function update(string $id, Request $request) 
    {
        // 1. mencari data
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // 2. validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Menjadi nullable karena gambar opsional saat update
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. siapkan data yang ingin diupdate
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ];

        // 4. handle image (upload & delete image)
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image->store('books', 'public');
            if ($book->cover_photo) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }
            $data['cover_photo'] = $image->hashName();
        }

        // 5. update data baru ke database
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $book
        ], 200);
    }
    public function show(string $id){
        $book = Book::find($id);
    if (!$book) {
        return response()->json([
            'success'=> false,
            'message'=> 'resource not found'
            ],404);
    }
    return response()->json([
        'success'=> true,
        'message'=> 'get detail resource',
        'data'=> $book,
        ],200);
    }
    public function destroy(string $id){
        $book = Book::find($id);
        if (!$book) {  
            return response()->json([
                'success'=> false,
                'message'=> ''
                ],404);
        }if ($book->cover_photo) {
            Storage::disk('public')->delete('/books'.$book->cover_photo);}
        $book->delete();
        return response()->json([
            'success'=> true,
            'message'=> 'DELETE data resource' 
            ],200);
        }
    }
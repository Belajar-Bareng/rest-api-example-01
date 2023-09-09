<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Successfully fetch books',
            'data' => Book::limit($request->get('size') ?? 10)->when($request->get('search'), function ($query) use ($request) {
                return $query->where('title', $request->get('search'));
            })->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());
        return response()->json([
            'message' => 'Successfully create a new book',
        ]
        ,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json([
            'message' => 'Successfully get a book',
            'data' => $book,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->json([
            'message' => 'Successfully updated a book',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message' => 'Successfully deleted a book'
        ], 200);
    }
}

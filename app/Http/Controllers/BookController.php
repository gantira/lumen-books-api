<?php

namespace App\Http\Controllers;

use App\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Return the list of books
     * return Illuminte/Http/Response
     */
    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Create new one book
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $books = Book::create($request->all());

        return $this->successResponse($books, Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one book
     * @return Illuminate/Http/Response
     */
    public function show($book)
    {
        $book = Book::findOrFail($book);

        return $this->successResponse($book);
    }

    /**
     * Update an existing book
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $book)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $book = Book::findOrFail($book);

        $book->fill($request->all());

        if ($book->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();

        return $this->successResponse($book); 
    }

    /**
     * Remove an existing book
     * @return Illuminate/Http/Response
     */
    public function destroy($book)
    {
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successResponse($book);
    }
}

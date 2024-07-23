<?php

namespace App\Http\Controllers\Book;

use App\Traits\CurlTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    use CurlTrait;

    /**
     * Create Book with author.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $token = session('api_token');
        $route = env('API_URL').'/api/v2/authors';
        $authors = $this->callInternalGetApi($route, $token);
        if (isset($authors['code']) && $authors['code'] != 403) {
            return redirect()->route('authors')->withErrors(['Unauthorized']);
        }
        return view('book.create', compact('authors'));
    }
    /**
     * Store Book with author.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|array|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
        ]);

        $token = session('api_token');
        $route = env('API_URL').'/api/v2/books';
        $data = [
            'author' => $request->author,
            'title' => $request->title,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'format' => $request->format,
            'number_of_pages' => (int) $request->number_of_pages,
        ];
        $book = $this->callExternalPostWithHeaderApi($route, $token, $data);
        if (isset($book['code']) && $book['code'] != 200) {
            return redirect()->route('books.create')->withErrors(['Something went wrong.']);
        }
        return redirect()->route('authors')->with('success', 'Book created successfully');
    }

    /**
     * Delete book by book id
     *
     * @param int $bookId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy(Request $request, $bookId)
    {
        $token = session('api_token');
        $route = env('API_URL').'/api/v2/books/' . $bookId;
        $book = $this->callInternalDeleteApi($route, $token);
        if (isset($book['code']) && $book['code'] != 200) {
            return redirect()->route('authors.view', $request->authorId)->withErrors(['Book not able to delete.']);
        }

        return redirect()->route('authors.view', $request->authorId)->with('success', 'Book deleted successfully');
    }
}

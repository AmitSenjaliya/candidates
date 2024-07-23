<?php

namespace App\Http\Controllers\Author;

use App\Traits\CurlTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    use CurlTrait;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $token = session('api_token');
        $route = env('API_URL').'/api/v2/authors';
        $data = [
            'orderBy' => 'id',
            'direction' => 'asc',
            'limit' => 10,
            'page' => 1,
        ];
        $authors = $this->callInternalGetApi($route, $token, $data);
        if (isset($authors['code']) && $authors['code'] != 403) {
            return redirect()->route('authors')->withErrors(['Unauthorized']);
        }
        return view('author.index', compact('authors'));
    }

    /**
     * Delete author if books not found.
     *
     * @param int $authorId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($authorId)
    {
        $token = session('api_token');
        $route = env('API_URL').'/api/v2/authors/' . $authorId;
        $author = $this->callInternalGetApi($route, $token);
        if (isset($author['code']) && $author['code'] != 200) {
            return redirect()->route('authors')->withErrors(['Unauthorized']);
        }
        if (!empty($author['books'])) {
            return redirect()->route('authors')->with('error', 'Author cannot be deleted because there are related books found.');
        }

        // Delete author if not found any related books.
        $author = $this->callInternalDeleteApi($route, $token);
        if (isset($author['code']) && $author['code'] != 200) {
            return redirect()->route('authors')->withErrors(['Author not be deleted.']);
        }

        return redirect()->route('authors')->with('success', 'Author deleted successfully');
    }

    /**
     * View author and related books.
     *
     * @param int $authorId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view($authorId)
    {
        $token = session('api_token');
        $route = env('API_URL').'/api/v2/authors/' . $authorId;
        $author = $this->callInternalGetApi($route, $token);
        if (isset($author['code']) && $author['code'] != 200) {
            return redirect()->route('authors')->withErrors(['Unauthorized']);
        }
        return view('author.view', compact('author'));
    }
}

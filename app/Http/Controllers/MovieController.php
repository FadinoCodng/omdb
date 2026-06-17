<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Services\OmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected OmdbService $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    /**
     * Dashboard — show default movies
     */
    public function dashboard()
    {
        $result = $this->omdbService->search('Marvel', 1);

        $movies = $result['results'] ?? [];
        $userFavorites = [];

        if (Auth::check()) {
            $userFavorites = Favorite::where('user_id', Auth::id())
                ->pluck('imdb_id')
                ->toArray();
        }

        return view('dashboard.index', compact('movies', 'userFavorites'));
    }

    /**
     * Search page
     */
    public function searchPage()
    {
        $userFavorites = [];

        if (Auth::check()) {
            $userFavorites = Favorite::where('user_id', Auth::id())
                ->pluck('imdb_id')
                ->toArray();
        }

        return view('search.search', compact('userFavorites'));
    }

    /**
     * AJAX search endpoint
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
            'page' => 'nullable|integer|min:1',
            'type' => 'nullable|string|in:movie,series,episode',
        ]);

        $query = $request->input('q');
        $page = $request->input('page', 1);
        $type = $request->input('type');

        $result = $this->omdbService->search($query, $page, $type);

        // Attach favorite status
        if ($result['success'] && Auth::check()) {
            $userFavorites = Favorite::where('user_id', Auth::id())
                ->pluck('imdb_id')
                ->toArray();

            foreach ($result['results'] as &$movie) {
                $movie['isFavorite'] = in_array($movie['imdbID'], $userFavorites);
            }
        }

        return response()->json($result);
    }

    /**
     * AJAX detail endpoint
     */
    public function detail(string $imdbId)
    {
        $result = $this->omdbService->getById($imdbId);

        return response()->json($result);
    }

    /**
     * Toggle favorite (add/remove)
     */
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:20',
            'type' => 'nullable|string|max:50',
            'poster' => 'nullable|string|max:500',
        ]);

        $userId = Auth::id();
        $imdbId = $request->input('imdb_id');

        $existing = Favorite::where('user_id', $userId)
            ->where('imdb_id', $imdbId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => __('Removed from favorites'),
            ]);
        }

        Favorite::create([
            'user_id' => $userId,
            'imdb_id' => $imdbId,
            'title' => $request->input('title'),
            'year' => $request->input('year'),
            'type' => $request->input('type'),
            'poster' => $request->input('poster'),
        ]);

        return response()->json([
            'success' => true,
            'action' => 'added',
            'message' => __('Added to favorites'),
        ]);
    }

    /**
     * Favorites page
     */
    public function favorites()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favorit.favorites', compact('favorites'));
    }
}

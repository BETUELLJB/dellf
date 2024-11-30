<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function index(Request $request)
    {
        $movies = null;
        $newMovies = $this->tmdbService->getNewMovies(); // Buscar 6 filmes novos

        if ($request->has('query') && $request->query('query') !== '') {
            $request->validate([
                'query' => 'required|string|min:3',
            ]);

            $movies = $this->tmdbService->searchMovie($request->query('query'));
        }

        return view('movies.index', compact('movies', 'newMovies'));
    }


    // Método para exibir os detalhes do filme
    public function show($movie_id)
    {
        $movieDetails = $this->tmdbService->getMovieDetails($movie_id);

        return view('movies.show', compact('movieDetails'));
    }
}

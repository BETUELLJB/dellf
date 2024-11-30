<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    // Define a chave da API a partir do .env
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
    }

    // Método para buscar filmes pela palavra-chave
    public function searchMovie($query)
    {
        $url = "https://api.themoviedb.org/3/search/movie?api_key={$this->apiKey}&query={$query}&language=pt-BR";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    // Método para buscar detalhes de um filme pelo ID
    public function getMovieDetails($movieId)
    {
        $url = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$this->apiKey}&language=pt-BR";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getNewMovies()
{
    $url = 'https://api.themoviedb.org/3/movie/now_playing';
    $response = Http::get($url, [
        'api_key' => env('TMDB_API_KEY'),
        'language' => 'pt-BR',
        'page' => 1,
    ]);

    return $response->json()['results'];
}

}

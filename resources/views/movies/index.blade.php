@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pesquisar Filmes</h1>

        <!-- Formulário de Pesquisa -->
        <form action="{{ route('movies.index') }}" method="GET">
            <div class="form-group">
                <input type="text" name="query" class="form-control" placeholder="Pesquise um filme..." value="{{ request()->query('query') }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Pesquisar</button>
        </form>

        <!-- Exibição dos Filmes Recentes -->
        <h2 class="mt-4">Lançamentos Recentes</h2>
        <div class="row">
            @foreach($newMovies as $movie)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if($movie['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                        @else
                            <img src="https://via.placeholder.com/300x450" class="card-img-top" alt="Imagem não disponível">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie['title'] }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($movie['overview'], 100) }}</p>
                            <a href="{{ route('movies.show', $movie['id']) }}" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Exibição dos Resultados da Pesquisa -->
        @if(isset($movies) && $movies && count($movies['results']) > 0)
            <h2 class="mt-4">Resultados</h2>
            <div class="row">
                @foreach($movies['results'] as $movie)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" class="card-img-top" alt="{{ $movie['title'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $movie['title'] }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($movie['overview'], 100) }}</p>
                                <a href="{{ route('movies.show', $movie['id']) }}" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(request()->has('query') && $movies && count($movies['results']) == 0)
            <p class="mt-4">Nenhum filme encontrado para "{{ request()->query('query') }}".</p>
        @endif
    </div>
@endsection

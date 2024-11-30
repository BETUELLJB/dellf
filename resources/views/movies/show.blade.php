@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $movieDetails['title'] }}</h1>

        <div class="row">
            <div class="col-md-4">
                @if($movieDetails['poster_path'])
                    <img src="https://image.tmdb.org/t/p/w500{{ $movieDetails['poster_path'] }}" class="img-fluid" alt="{{ $movieDetails['title'] }}">
                @else
                    <p>Imagem não disponível</p>
                @endif
            </div>

            <div class="col-md-8">
                <h3>Resumo:</h3>
                <p>{{ $movieDetails['overview'] }}</p>

                <h3>Avaliação:</h3>
                <p>{{ $movieDetails['vote_average'] }} / 10</p>

                <h3>Data de Lançamento:</h3>
                <p>{{ $movieDetails['release_date'] }}</p>

                <h3>Gêneros:</h3>
                <ul>
                    @foreach($movieDetails['genres'] as $genre)
                        <li>{{ $genre['name'] }}</li>
                    @endforeach
                </ul>

                <h3>Idioma:</h3>
                <p>{{ $movieDetails['original_language'] }}</p>

                <h3>Detalhes adicionais:</h3>
                <p>O filme foi popular no sistema de classificação com uma nota média de {{ $movieDetails['vote_average'] }} / 10.</p>
            </div>
        </div>
        <a href="{{ route('movies.index') }}" class="btn btn-primary mt-3">Voltar para a Pesquisa</a>
    </div>
@endsection

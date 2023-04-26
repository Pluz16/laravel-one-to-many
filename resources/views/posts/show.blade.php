@extends('layouts.app')

@section('content')
        <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="me-auto">{{ $post->title }}</h1>
            <div class="d-flex align-items-center">
            @if($post->category)
                <span class="badge rounded-pill bg-warning me-3">{{ $post->category->name }}</span>
            @else
                <span class="badge rounded-pill bg-secondary me-3">Nessuna categoria</span>
            @endif
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary">Modifica</a>
            </div>
        </div>
        </div>


            <div class="d-flex">
                <a class="btn btn-sm btn-secondary" href="{{ route('posts.edit',$post) }}">Modifica</a>
                @if($post->trashed())
                    <form action="{{ route('posts.restore',$post) }}" method="POST">
                      @csrf
                      <input class="btn btn-sm btn-success" type="submit" value="Ripristina">
                    </form>
                @endif
            </div>
            
        </div>
    </div>
    <div class="container">
        <p>
            {{ $post->content }}
        </p>
    </div>
@endsection
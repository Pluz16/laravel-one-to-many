@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Nuovo post</h1>
    </div>
    <div class="container">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Titolo</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" id="title" aria-describedby="titleHelp">
              {{-- errore title --}}
              @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
            <label for="category-select" class="form-label">Categoria</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category-select" name="category_id" aria-label="Seleziona categoria">
              <option value="" selected>Scegli una categoria</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
              @endforeach
            </select>
            @error('category_id')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

            <div class="mb-3">
              <label for="content" class="form-label">Contenuto</label>
              <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content">{{ old('content') }}</textarea>
              @error('content')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Crea</button>
          </form>
    </div>
@endsection
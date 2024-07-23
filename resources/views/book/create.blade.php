@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add new book') }}</div>

                <div class="card-body">
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $message )
                            <div class="alert alert-danger display-hide">
                                <span>{{ $message }}</span>
                            </div>
                        @endforeach
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div><br>
                        <div class="form-group">
                            <label for="author">Author:</label>
                            <select class="form-control" name="author[id]" required>
                                <option>Select Author</option>
                                @forelse ($authors['items'] as $author)
                                    <option value="{{ $author['id'] }}"> {{ $author['first_name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="release_date">Release Date:</label>
                            <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date') }}">
                        </div><br>
                        <div class="form-group">
                            <label for="number_of_pages">Number of pages:</label>
                            <input type="number" class="form-control" id="number_of_pages" name="number_of_pages" value="{{ old('number_of_pages') }}">
                        </div><br>

                        <div class="form-group">
                            <label for="isbn">Isbn:</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn') }}">
                        </div><br>

                        <div class="form-group">
                            <label for="format">Format:</label>
                            <input type="text" class="form-control" id="format" name="format" value="{{ old('format') }}">
                        </div><br>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Author Detail') }}</div>

                <div class="card-body">
                    <ul>
                        <li> First Name: {{ $author['first_name'] }}</li>
                        <li> Last Name: {{ $author['last_name'] }}</li>
                        <li> Birthday: {{ date('d-m-Y', strtotime($author['birthday'])) }}</li>
                        <li> Biography: {{ $author['biography'] }}</li>
                        <li> Gender: {{ $author['gender'] }}</li>
                        <li> Place of birth: {{ $author['place_of_birth'] }}</li>
                    </ul>
                    <hr>
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
                    <h4>List of all author books</h4>
                    <a href="{{ route('books.create') }}" class="btn btn-success btn-sm float-end">Add New Book</a>
                    <br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Release date</th>
                                <th>Description</th>
                                <th>Number of pages</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($author['books'] as $key => $book)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $book['title'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($book['release_date'])) }}</td>
                                    <td>{{ $book['description'] }}</td>
                                    <td>{{ $book['number_of_pages'] }}</td>
                                    <td>
                                    <form action="{{ route('books.destroy', $book['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="authorId" value="{{ $author['id'] }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

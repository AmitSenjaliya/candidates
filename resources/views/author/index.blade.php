@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Authors') }}</div>

                <div class="card-body">
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Place of Birth</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authors['items'] as $key => $author)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $author['first_name'] }}</td>
                                    <td>{{ $author['last_name'] }}</td>
                                    <td>{{ $author['gender'] }}</td>
                                    <td>{{ $author['place_of_birth'] }}</td>
                                    <td>
                                        <form action="{{ route('authors.destroy', $author['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        <p></p>
                                        <a href="{{ route('authors.view', $author['id']) }}" class="btn btn-success btn-sm">View</a>
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

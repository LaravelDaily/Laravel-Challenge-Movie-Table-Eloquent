@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ str_replace('100', $topX, __('TOP 100 Movies')) }}</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Release Year</th>
                                <th>Avg Rating</th>
                                <th>Votes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rankedMovies as $rankedMovie)
                                <tr>
                                    <td>{{ $loop->iteration }}. {{ $rankedMovie->title }}</td>
                                    <td>{{ $rankedMovie->category_name }}</td>
                                    <td>{{ $rankedMovie->release_year }}</td>
                                    <td>{{ number_format($rankedMovie->ave_rating, 2) }}</td>
                                    <td>{{ $rankedMovie->votes }}</td>
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

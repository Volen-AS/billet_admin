@extends('layouts.app')

@section('content')
    <div class="container">
{{--        @if(session('success'))--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-md-12">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}
        <div class="row justify-content-center">
            <din class="col-md-12">
                @include('blog.admin.posts.includes.result_messages')
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <a class="btn btn-primary" href="{{ route('blog.admin.posts.create') }}" > Create Post</a>
                </nav>
                <div class="card">

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Autor</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Published Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $post)
                                @php
                                /** @var \App\Models\BlogPost $post */
                                @endphp
                                <tr @if(!$post->is_published) style="background-color: #ccc"  @endif>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td> {{ $post->category->title }}</td>
                                    <td>
                                        <a href="{{ route('blog.admin.posts.edit', $post->id) }}">{{ $post->title }}</a>
                                    </td>
                                    <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.M H:i') : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </din>
        </div>

        @if($paginator->total() > $paginator->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $paginator->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

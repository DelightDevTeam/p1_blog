@extends('layouts.master')


@section('content')

<h1 class="mt-4">Post</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Post Show</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <a href="{{ route('posts.index') }}" class="btn btn-primary">Back</a>
                            </div>
                           
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Post Show
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PostTitle</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>CreatedAt</th>
                                            
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td>{{ $post->category->name }}</td>
                                            <td>{{ $post->title}}</td>
                                            <td>{{ $post->content}}</td>
                                            <td>
                                                @if ($post->image)
                                                    <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100px; height: auto;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at }}</td>

                                            
                                        </tr>
</tbody>
                                </table>
                            </div>
                        </div>
@endsection
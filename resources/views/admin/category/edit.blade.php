@extends('layouts.master')


@section('content')

<h1 class="mt-4">Categories</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Categories Edit</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Categories Edit
                            </div>
                            <div class="card-body">
                                <form action="{{ route('categories.update', $category->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
@endsection
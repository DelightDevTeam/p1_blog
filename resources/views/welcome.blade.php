@include('layout_user.head')
    <body>
        <!-- Responsive navbar-->
        @include('layout_user.navbar')
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                     @if($posts->count() > 0)
                     @foreach($posts as $post)
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{ $post->created_at->format('F d, Y') }} by {{ $post->user->name }}</div>
                            <!-- Post categories-->
                            <!-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">Web Design</a>
                            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a> -->
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="{{ asset('images/' . $post->image) }}"" alt="{{ $post->title }}" /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4">{{ $post->content }}</p>
                        </section>
                        <div class="text-muted fst-italic mb-2">
                            <!-- detail -->
                            <a href="{{ route('postsdetail.show', $post->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </article>
                    @endforeach
                    @else
                    <p>No posts found</p>
                    @endif
                    <!-- Comments section-->
                    <section class="mb-5">

                    </section>
                </div>
                <!-- Side widgets-->
                @include('layout_user.side_widget')
            </div>
        </div>
        <!-- Footer-->
        @include('layout_user.footer')

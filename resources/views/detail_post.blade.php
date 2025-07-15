@include('layout_user.head')
    <body>
        <!-- Responsive navbar-->
        @include('layout_user.navbar')
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                     
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                             <h1>Post Detail</h1>
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
                            <a href="{{ route('user_home') }}" class="btn btn-primary">Back</a>
                        </div>
                    </article>
                   
                    <!-- Comments section-->
                    <section class="mb-5">
                        @include('layout_user.comment_section')
                    </section>
                </div>
                <!-- Side widgets-->
            </div>
        </div>
        <!-- Footer-->
        @include('layout_user.footer')

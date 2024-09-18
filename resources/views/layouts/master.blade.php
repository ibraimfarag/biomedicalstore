@include('layouts.head')



{{-- @include('layouts.sidebar')

@include('layouts.content') --}}




<div class="main-container">
    @include('layouts.sidebar')

    <main>
        @include('layouts.header')
        @if (session('success'))
            <div class="alert alert-p alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-p alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @include('layouts.content')
    </main>
</div>

@include('layouts.footer')

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@elseif (session('info'))
    <div class="alert alert-danger" role="alert">
        {{ session('info') }}
    </div>
@endif
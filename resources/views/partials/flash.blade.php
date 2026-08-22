@if(session('success'))
    <div class="alert alert-success wb-reveal" role="status">
        <x-icon name="check" />
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger wb-reveal" role="alert">
        <x-icon name="alert" />
        <div>{{ session('error') }}</div>
    </div>
@endif

@if (session('successMessage'))
    <x-alert class="mb-3" color="success">
        {{ session('successMessage') }}
    </x-alert>
@endif

@if (session('dangerMessage'))
    <x-alert class="mb-3" color="danger" dismissible>
        {{ session('dangerMessage') }}
    </x-alert>
@endif

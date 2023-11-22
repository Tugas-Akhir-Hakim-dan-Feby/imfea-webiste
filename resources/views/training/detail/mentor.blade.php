<x-card>
    <x-slot:header>
        <h3 class="fw-semibold">Mentor</h3>
    </x-slot:header>
    <x-slot:body>
        <div class="d-flex align-items-center">
            <img class="img-fluid objectfit-cover rounded-2"
                src="https://ui-avatars.com/api/?background=random&size=50&length=2&name={{ $training->user->name }}"
                alt="{{ $training->user->name }}">
            <h5 class="fw-bolder ms-2">{{ $training->user->name }}</h5>
        </div>
    </x-slot:body>
</x-card>

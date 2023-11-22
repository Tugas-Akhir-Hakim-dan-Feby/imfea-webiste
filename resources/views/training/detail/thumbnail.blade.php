<x-card :image="$training->thumbnail">
    @if (auth()->user()->isMember())
        <x-button label="Mulai Belajar" class="text-white w-100" color="primary" route="web.training.course.slug"
            :parameter="[
                'trainingSlug' => $training->slug,
                'courseSlug' => $training->topics[0]->courses[0]->slug,
            ]" />
    @endif
</x-card>

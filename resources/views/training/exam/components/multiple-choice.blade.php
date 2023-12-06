<x-col>
    @if ($exam && $exam->answers)
        @foreach ($exam->answers as $key => $answer)
            <x-row class="mb-3">
                <x-label label="Jawaban {{ $key + 1 }}" />
                <x-col class="d-flex">
                    <input type="text" name="answers[{{ $key + 1 }}]" id="answers" class="form-control me-2"
                        value="{{ $answer->answer }}" required>
                </x-col>
            </x-row>
        @endforeach
    @else
        @for ($i = 1; $i <= 5; $i++)
            <x-row class="mb-3">
                <x-label label="Jawaban {{ $i }}" />
                <x-col class="d-flex">
                    <input type="text" name="answers[{{ $i }}]" id="answers" class="form-control me-2"
                        required>
                </x-col>
            </x-row>
        @endfor
    @endif
</x-col>


<x-select id="correct_answer" label="Kunci Jawaban" required>
    @if ($exam && $exam->answers)
        @foreach ($exam->answers as $key => $answer)
            <option value="{{ $key + 1 }}" {{ $answer->id == $exam->exam_answer_id ? 'selected' : '' }}>Jawaban
                {{ $key + 1 }}</option>
        @endforeach
    @else
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">Jawaban {{ $i }}</option>
        @endfor
    @endif
</x-select>

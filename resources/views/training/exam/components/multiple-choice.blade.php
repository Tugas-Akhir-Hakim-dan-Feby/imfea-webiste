@if ($exam)
    @foreach ($exam->answers as $index => $answer)
        <x-col class="duplication" id="answer-{{ $index }}" data-id="{{ $index }}">
            <x-row class="mb-3">
                <x-col class="d-flex">
                    <input type="text" name="answers[]" id="answers" class="form-control me-2"
                        value="{{ $answer->answer }}" required>
                    <x-button color="danger" id="deleteAnswer">
                        <x-icon name="mdi mdi-trash-can" />
                    </x-button>
                </x-col>
            </x-row>
        </x-col>
    @endforeach
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Jawaban</th>
                    <th>Kunci Jawaban</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="duplication" id="answer-0" data-id="0">
                    <td>
                        <input type="text" name="answers[]" id="answers" class="form-control me-2" required>
                    </td>
                    <td style="vertical-align: middle">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" name="correct_answer"
                                style="height: 23px; width: 23px">
                        </div>
                    </td>
                    <td class="text-center">
                        <x-button color="danger" id="deleteAnswer">
                            <x-icon name="mdi mdi-trash-can" />
                        </x-button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

{{-- <x-select id="correct_answer" label="Kunci Jawaban" required>
    @if ($exam)
        @foreach ($exam->answers as $answer)
            <option value="{{ $answer->answer }}" @selected($exam->exam_answer_id == $answer->id)>{{ $answer->answer }}</option>
        @endforeach
    @else
        <option />
    @endif
</x-select> --}}

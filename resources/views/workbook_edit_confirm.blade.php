@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' =>  ['workbook.edit.complete', $workbook->getWorkbookId()]])}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>以下で編集してよろしいですか？</p>
            <div>
                <label>問題集のタイトル</label>
                <p>{{ $workbook->getTitle() }}</p>
                <input type="hidden" name="title" value="{{ $workbook->getTitle() }}">
            </div>
            <div>
                <label>問題集の説明</label>
                <p>{{ $workbook->getExplanation() }}</p>
                <input type="hidden" name="explanation" value="{{ $workbook->getExplanation() }}">
            </div>
            @isset($exercise_list)
            <div>
                <label>問題</label>
                <ul>
                    @foreach($exercise_list as $exercise)
                        <li>{{ $exercise->getQuestion() }}</li>
                        <input type="hidden" name="exercise[]" value="{{ $exercise->getExerciseId() }}" />
                    @endforeach
                </ul>
            </div>
            @endisset
        </div>
    </div>
    <div class="btn-group d-flex pb-2" role="group" aria-label="...">
        <a href="{{route('workbook.edit', $workbook->getWorkbookId())}}"
           class="btn btn-outline-secondary w-100">戻る</a>
        <input type="submit"
               class="btn btn-outline-primary w-100" value="作成" />
    </div>
    {{Form::close()}}
</div>
@endsection

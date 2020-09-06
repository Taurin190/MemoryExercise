@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' => [ 'workbook.complete']])}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>以下を作成してよろしいですか？</p>
            <div>
                <label>問題集のタイトル</label>
                <p>{{ $workbook->getTitle() }}</p>
                <input type="hidden" name="title" value="{{ $workbook->getTitle() }}">
            </div>
            <div>
                <label>問題集の説明</label>
                <p>{!! nl2br(e($workbook->getExplanation())) !!}</p>
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
        <a href="{{route('workbook.create')}}"
           class="btn btn-outline-secondary w-100">戻る</a>
        <input type="submit"
               class="btn btn-outline-primary w-100" value="作成" />
    </div>
    {{Form::close()}}
</div>
@endsection

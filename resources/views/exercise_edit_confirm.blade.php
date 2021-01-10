@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' =>  ['exercise.edit.complete', $exercise->getExerciseId()]])}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>以下で編集してよろしいですか？</p>
            <div>
                <label>問題</label>
                <p>{{ $exercise->getQuestion() }}</p>
                <input type="hidden" name="title" value="{{ $exercise->getQuestion() }}">
            </div>
            <div>
                <label>解答</label>
                <p>{{ $exercise->getAnswer() }}</p>
                <input type="hidden" name="explanation" value="{{ $exercise->getAnswer() }}">
            </div>
        </div>
    </div>
    <div class="btn-group d-flex pb-2" role="group" aria-label="...">
        <a href="{{route('exercise.edit', $exercise->getExerciseId())}}"
           class="btn btn-outline-secondary w-100">戻る</a>
        <input type="submit"
               class="btn btn-outline-primary w-100" value="編集" />
    </div>
    {{Form::close()}}
</div>
@endsection

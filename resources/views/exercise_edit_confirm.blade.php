@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' =>  ['exercise.edit.complete', $exercise->getExerciseId()]])}}
    <div class="row justify-content-center">
        <div class="card col-md-10 py-5 px-5">
            <p>以下で編集してよろしいですか？</p>
            <div>
                <label class="pt-2 my-2 form-label control-label">問題</label>
                <p>{{ $exercise->getQuestion() }}</p>
                <input type="hidden" name="title" value="{{ $exercise->getQuestion() }}">
            </div>
            <div>
                <label class="pt-2 my-2 form-label control-label">解答</label>
                <p>{{ $exercise->getAnswer() }}</p>
                <input type="hidden" name="explanation" value="{{ $exercise->getAnswer() }}">
            </div>
            <div class="col-md-12 px-0 pt-3 btn-group d-flex" role="group" aria-label="...">
                <a href="{{route('exercise.edit', $exercise->getExerciseId())}}"
                   class="btn btn-outline-secondary px-0 col-md-3 float-left">戻る</a>
                <input type="submit"
                       class="btn btn-outline-primary px-0 mx-2 float-left col-md-3" value="編集" />
            </div>
        </div>
    </div>
    {{Form::close()}}
</div>
@endsection

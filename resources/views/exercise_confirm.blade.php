@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' => [ 'exercise.complete']])}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>以下を作成してよろしいですか？</p>
            <div>
                <label>問題</label>
                <p>{{ $exercise->getQuestion() }}</p>
                <input type="hidden" name="question" value="{{ $exercise->getQuestion() }}">
            </div>
            <div>
                <label>解答</label>
                <p>{{ $exercise->getAnswer() }}</p>
                <input type="hidden" name="answer" value="{{ $exercise->getAnswer() }}">
            </div>
        </div>
    </div>
    <div class="btn-group d-flex pb-2" role="group" aria-label="...">
        <button type="button"
                class="btn btn-outline-secondary w-100">戻る</button>
        <input type="submit"
                class="btn btn-outline-primary w-100" value="作成" />
    </div>
    {{Form::close()}}
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' => [ 'exercise.complete']])}}
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
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
            <div>
                <label>公開設定</label>
                @if ($exercise->getPermission() === 1)
                <p>公開</p>
                @else
                <p>非公開</p>
                @endif
            </div>
        </div>
    </div>
    <div class="btn-group d-flex pb-2" role="group" aria-label="...">
        <a href="{{route('exercise.create')}}"
                class="btn btn-outline-secondary w-100">戻る</a>
        <input type="submit"
                class="btn btn-outline-primary w-100" value="作成" />
    </div>
    {{Form::close()}}
</div>
@endsection

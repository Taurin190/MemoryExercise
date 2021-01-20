@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' => [ 'exercise.complete']])}}
    <div class="row justify-content-center">
        <div class="card col-md-10 py-5 px-5">
            <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題作成</h2>
            <p>以下の内容を作成してよろしいですか？</p>
            <div>
                <label class="pt-2 my-2 form-label control-label">問題</label>
                <p>{{ $exercise->getQuestion() }}</p>
                <input type="hidden" name="question" value="{{ $exercise->getQuestion() }}">
            </div>
            <div>
                <label class="pt-2 my-2 form-label control-label">解答</label>
                <p>{{ $exercise->getAnswer() }}</p>
                <input type="hidden" name="answer" value="{{ $exercise->getAnswer() }}">
            </div>
            <div class="mb-3">
                <label class="pt-2 my-2 form-label control-label">公開設定</label>
                @if ($exercise->getPermission() === 1)
                <p>公開</p>
                <input type="hidden" name="permission" value="{{ $exercise->getPermission() }}">
                @else
                <p>非公開</p>
                <input type="hidden" name="permission" value="{{ $exercise->getPermission() }}">
                @endif
            </div>
            <div class="col-md-12 px-0 btn-group d-flex" role="group" aria-label="...">
                <a href="{{route('exercise.create')}}"
                   class="btn btn-outline-secondary px-0 col-md-3 float-left">戻る</a>
                <input type="submit"
                       class="btn btn-outline-primary px-0 mx-2 float-left col-md-3" value="作成" />
            </div>
        </div>
    </div>
    {{Form::close()}}
</div>
@endsection

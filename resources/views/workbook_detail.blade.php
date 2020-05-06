@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{ $workbook->getTitle() }}</h2>
            @if(!empty($workbook->getExplanation()))
                <span>{{ $workbook->getExplanation() }}</span>
            @endif
            {{Form::open(['route' => [ 'workbook.complete', $workbook->getWorkbookId()]])}}
            @foreach($workbook->getExerciseList() as $exercise)
                <p>{{ $exercise->getQuestion() }}</p>
                <div>
                    <a data-toggle="collapse" href="#collapse-{{$exercise->getExerciseId()}}">解答を表示</a>
                    <div id="collapse-{{$exercise->getExerciseId()}}" class="collapse card">
                        <div class="card-body">{{ $exercise->getAnswer() }}</div>
                    </div>
                </div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons" role="group" aria-label="{{ $exercise->getExerciseId() }}">
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off" checked>覚えた</input>
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off">ちょっと怪しい</input>
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off">分からない</input>
                    </label>
                </div>
            @endforeach
            <div>
                <button class="btn btn-primary btn-block">回答完了</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

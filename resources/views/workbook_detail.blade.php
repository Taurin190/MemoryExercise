@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $workbook->getTitle() }}</h1>
            @if(!empty($workbook->getExplanation()))
                <div class="card">
                    <div class="card-body">{{ $workbook->getExplanation() }}</div>
                </div>
            @endif
            @php($problem_count = 0)
            {{Form::open(['route' => [ 'workbook.complete', $workbook->getWorkbookId()]])}}
            @foreach($workbook->getExerciseList() as $exercise)
                @php($problem_count++)
                <div class="py-4">
                    <b>問題{{$problem_count}}</b>
                    <p>{{ $exercise->getQuestion() }}</p>
                    <div class="pb-4">
                        <a data-toggle="collapse" href="#collapse-{{$exercise->getExerciseId()}}">解答を表示</a>
                        <div id="collapse-{{$exercise->getExerciseId()}}" class="collapse card">
                            <div class="card-body">
                                <b>解答</b>
                                {{ $exercise->getAnswer() }}
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" role="group" aria-label="{{ $exercise->getExerciseId() }}">
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" name="{{$exercise->getExerciseId()}}" value="ok">覚えた</input>
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" autocomplete="off" name="{{$exercise->getExerciseId()}}" value="studying">ちょっと怪しい</input>
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio" autocomplete="off" name="{{$exercise->getExerciseId()}}" value="ng" checked required>分からない</input>
                        </label>
                    </div>
                    <input type="hidden" name="exercise_list[]" value="{{$exercise->getExerciseId()}}" />
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

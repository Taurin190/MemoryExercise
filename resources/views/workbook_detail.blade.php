@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{ $workbook->getTitle() }}</h2>
            @if(!empty($workbook->getExplanation()))
                <span>{{ $workbook->getExplanation() }}</span>
            @endif
            @foreach($workbook->getExerciseList() as $exercise)
                <p>{{ $exercise->getQuestion() }}</p>
                <a data-toggle="collapse" href="#collapse-{{$exercise->getExerciseId()}}">解答を表示</a>
                <div id="collapse-{{$exercise->getExerciseId()}}" class="collapse card">
                    <div class="card-body">{{ $exercise->getAnswer() }}</div>
                </div>
            @endforeach
            <div></div>
        </div>
    </div>
</div>
@endsection

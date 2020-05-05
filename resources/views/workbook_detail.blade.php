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
                <p>{{ $exercise->getAnswer() }}</p>
            @endforeach
            <div></div>
        </div>
    </div>
</div>
@endsection

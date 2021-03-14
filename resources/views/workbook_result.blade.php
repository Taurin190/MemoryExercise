@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-10 pt-5 px-5 mx-auto component-block">
            <h2>{{ $workbook->getTitle() }}</h2>
            @if(!empty($workbook->getExplanation()))
                <div class="card pb-2">
                    <div class="card-body">{{ $workbook->getExplanation() }}</div>
                </div>
            @endif
            <div class="my-5">
                <h3>問題数 ({{$answer->getExerciseCount()}})</h3>
                <answer-graph-component :chartdata='@json($answer_graph_data)' :count='@json($exercise_count)'></answer-graph-component>
            </div>
            <div class="pager-block">
                <a class="btn btn-primary btn-block" href="{{route('workbook.list')}}" >問題集一覧に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

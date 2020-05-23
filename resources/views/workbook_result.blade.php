@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 component-block">
            <h2>{{ $workbook->getTitle() }}</h2>
            @if(!empty($workbook->getExplanation()))
                <div class="card pb-2">
                    <div class="card-body">{{ $workbook->getExplanation() }}</div>
                </div>
            @endif
        </div>
        <div class="col-md-8 component-block">
            <div>
                <h2>問題数 ({{$answer->getExerciseCount()}})</h2>
                <answer-graph-component :chartdata='@json($answer_graph_data)' :count='@json($exercise_count)'></answer-graph-component>
                <ul class="list-inline">
                    <li class="list-inline-item col-3">覚えた数 ({{$answer->getOKCount()}})</li>
                    <li class="list-inline-item col-3">勉強中の数 ({{$answer->getStudyingCount()}})</li>
                    <li class="list-inline-item col-3">分からなかった数 ({{$answer->getNGCount()}})</li>
                </ul>
            </div>
            <div class="pager-block">
                <a class="btn btn-primary btn-block" href="{{route('workbook.list')}}" >問題集一覧に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

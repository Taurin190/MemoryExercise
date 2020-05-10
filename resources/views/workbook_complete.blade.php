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
                <p>覚えた数 ({{$answer->getOKCount()}})</p>
                <p>勉強中の数 ({{$answer->getStudyingCount()}})</p>
                <p>分からなかった数 ({{$answer->getNGCount()}})</p>
            </div>
            <div class="pager-block">
                <a class="btn btn-primary btn-block" href="{{route('workbook.list')}}" >問題集一覧に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

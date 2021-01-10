@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>編集しました。</p>
            <a class="btn btn-primary btn-block" href="{{route('exercise.list')}}" >問題一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

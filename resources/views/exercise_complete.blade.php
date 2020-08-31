@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>作成しました。</p>
            <a class="btn btn-primary btn-block" href="{{route('workbook.list')}}" >問題集一覧に戻る</a>
        </div>
    </div>
</div>
@endsection

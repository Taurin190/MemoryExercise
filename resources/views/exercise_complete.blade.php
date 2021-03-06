@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card col-md-10 py-3">
            <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題作成</h2>
            <p>作成しました。</p>
            <div class="col-md-12 px-0 btn-group d-flex">
                <a class="btn btn-primary btn-block px-0 col-md-3 float-left" href="{{route('workbook.list')}}" >問題集一覧に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

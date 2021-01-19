@extends('layouts.app')

@section('content')
<div class="container">
    @if(count($errors) > 0)
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="col-md-12 float-right alert alert-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="card py-5 px-5 col-md-10">
            <h2 class="mb-2"><i class="fas fa-book-open pr-2"></i>問題集作成</h2>
            {{Form::open(['route' => [ 'workbook.confirm']])}}
            <exercise-search-component></exercise-search-component>
            <input type="hidden" name="title" value="{{ $workbook->getTitle() }}">
            <input type="hidden" name="explanation" value="{{ $workbook->getExplanation() }}">
            {{--<div class="col-sm-offset-2 ">--}}
                {{--<button type="submit" class="btn btn-primary btn-block">作成</button>--}}
            {{--</div>--}}
            <div class="form-group">
                <div class="px-0 float-left col-md-3">
                    <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
                </div>
                <div class="px-0 mx-3 float-left col-md-3">
                    <button type="button" onclick="submit()" class="btn btn-primary btn-block">作成</button>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

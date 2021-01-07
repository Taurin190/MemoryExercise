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
        <div class="col-md-10">
            <h2 class="mb-3">問題集作成</h2>
            {{Form::open(['route' => [ 'workbook.confirm']])}}
            <div class="form-group py-1">
                <label class="control-label" for="InputTitle">タイトル</label>
                <div class="py-2">
                    <input type="text"
                           class="form-control "
                           id="InputTitle"
                           name="title"
                           placeholder="タイトル">
                </div>
            </div>
            <div class="form-group py-1">
                <label class="control-label" for="InputExplanation">説明</label>
                <div class="py-2">
                    <textarea rows="5"
                           class="form-control "
                           id="InputExplanation"
                           name="explanation"
                              placeholder="問題集の説明を入れてください。"></textarea>
                </div>
            </div>
            <exercise-search-component></exercise-search-component>
            {{--<div class="col-sm-offset-2 ">--}}
                {{--<button type="submit" class="btn btn-primary btn-block">作成</button>--}}
            {{--</div>--}}
            <div class="py-2 form-group">
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

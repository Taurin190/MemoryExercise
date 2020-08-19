@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
            {{Form::open(['route' => [ 'workbook.confirm']])}}
            <div class="form-group">
                <label class="control-label" for="InputTitle">問題集のタイトル</label>
                <div class="">
                    <input type="text"
                           class="form-control "
                           id="InputTitle"
                           name="title"
                           placeholder="タイトル">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="InputExplanation">問題集の説明</label>
                <div class="">
                    <textarea rows="5"
                           class="form-control "
                           id="InputExplanation"
                           name="explanation"
                              placeholder="問題集の説明を入れてください。"></textarea>
                </div>
            </div>
            <exercise-search-component></exercise-search-component>
            <div class="col-sm-offset-2 ">
                <button type="submit" class="btn btn-primary btn-block">作成</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

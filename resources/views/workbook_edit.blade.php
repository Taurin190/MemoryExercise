@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{Form::open(['route' => [ 'workbook.edit.confirm', $workbook->getWorkbookId()]])}}
            <div class="form-group">
                <label class="control-label" for="InputTitle">問題集のタイトル</label>
                <div class="">
                    <input type="text"
                           class="form-control "
                           id="InputTitle"
                           name="title"
                           value="{{ $workbook->getTitle() }}"
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
                              placeholder="問題集の説明を入れてください。">{{ $workbook->getExplanation() }}</textarea>
                </div>
            </div>
            <exercise-search-component :workbook='@json($workbook_array)'></exercise-search-component>
            <div class="col-sm-offset-2 ">
                <button type="submit" class="btn btn-primary btn-block">編集</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

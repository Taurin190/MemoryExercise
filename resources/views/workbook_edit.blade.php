@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card py-5 px-5 col-md-10">
            {{Form::open(['route' => [ 'workbook.edit.exercise', $workbook->workbook_id ]])}}
            <h2 class="mb-2"><i class="fas fa-book-open pr-2"></i>問題集編集</h2>
            <a class="text-decoration-none" data-toggle="modal" data-target="#deleteModal">
                <div class="exercise-delete">
                    <i class="far fa-trash-alt delete-icon"></i>
                </div>
            </a>
            <div class="form-group">
                <label class="form-label control-label py-2" for="InputTitle">問題集のタイトル</label>
                <div class="">
                    <input type="text"
                           class="form-control "
                           id="InputTitle"
                           name="title"
                           value="{{ $workbook->title }}"
                           placeholder="タイトル">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label control-label py-2" for="InputExplanation">問題集の説明</label>
                <div class="">
                    <textarea rows="5"
                           class="form-control "
                           id="InputExplanation"
                           name="explanation"
                              placeholder="問題集の説明を入れてください。">{{ $workbook->explanation }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="px-0 float-left col-md-3">
                    <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
                </div>
                <div class="px-0 mx-3 float-left col-md-3">
                    <button type="button" onclick="submit()" class="btn btn-primary btn-block">編集</button>
                </div>
            </div>
            {{Form::close()}}
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">削除しますか？</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ $workbook->title }}
                    </div>
                    {{Form::open(['route' => [ 'workbook.delete.complete', $workbook->workbook_id]])}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">キャンセル</button>
                        <button type="button" onclick="submit()" class="btn btn-danger">削除</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

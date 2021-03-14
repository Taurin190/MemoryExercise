@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card py-5 px-5 col-md-10">
            <h2 class="mb-2"><i class="fas fa-book-open pr-2"></i>問題集編集</h2>
            <a class="text-decoration-none" data-toggle="modal" data-target="#deleteModal">
                <div class="exercise-delete">
                    <i class="far fa-trash-alt delete-icon"></i>
                </div>
            </a>
            {{Form::open(['route' => [ 'workbook.edit.confirm', $workbook->workbook_id ]])}}
            <workbook-create-component :workbook='@json($workbook->toArray())'></workbook-create-component>
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

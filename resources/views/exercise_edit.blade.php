@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($errors) > 0)
        <div class="row">
            <div class="col-md-10 px-0 mx-auto">
                <div class="col-md-12 float-right alert alert-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
        </div>
        @endif
        {{Form::open(['route' => [ 'exercise.edit.confirm', $exercise->exercise_id ], 'onsubmit' => "return false;"])}}
         <div class="row justify-content-center">
             <div class="card col-md-10 py-5 px-5">
                 <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題編集</h2>
                 <a class="text-decoration-none" data-toggle="modal" data-target="#deleteModal">
                     <div class="exercise-delete">
                         <i class="far fa-trash-alt delete-icon"></i>
                     </div>
                 </a>
                 <div class="col-md-12 px-0 align-items-start mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                    <label class="pt-2 my-2 form-label control-label" for="InputQuestion">質問</label>
                    <div>
                        <textarea rows="2"
                               class="form-control"
                               id="InputQuestion"
                               name="question"
                               placeholder="パンはパンでも食べられないパンは何だ？"
                        >{{ $exercise->question }}</textarea>
                        @if(!empty($errors->first('question')))
                        <span class="text-danger">{{ $error }}</span>
                        @endif
                    </div>
                 </div>
                 <div class="align-items-start py-2 col-md-12 px-0 form-group @if(!empty($errors->first('answer'))) has-error @endif">
                    <label class="pb-2 form-label control-label" for="InputAnswer">答え</label>
                    <div>
                        <textarea rows="2"
                               class="form-control "
                               id="InputAnswer"
                               name="answer"
                               placeholder="フライパン"
                        >{{ $exercise->answer }}</textarea>
                        @if(!empty($errors->first('answer')))
                            <span class="text-danger">{{ $error }}</span>
                        @endif
                    </div>
                 </div>
                 <div class="py-2 form-group col-md-12 px-0">
                     <label class="form-label control-label pb-2">公開設定</label>
                     <div>
                         <input type="radio"
                                class=""
                                name="permission"
                                value="1"
                                checked="checked"
                         >
                         <label for="contactChoice1">公開</label>
                         <input type="radio"
                                class=""
                                name="permission"
                                value="0"
                         >
                         <label for="contactChoice1">非公開</label>
                     </div>
                 </div>
                 <div class="col-md-12 form-group px-0">
                     <label class="pb-2 form-label control-label" for="InputAnswer">カテゴリ</label>
                     <label-search-component></label-search-component>
                 </div>
                 <div class="py-2 col-md-12 form-group px-0">
                     <div class="px-0 col-md-3 float-left">
                         <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
                     </div>
                     <div class="px-0 mx-2 float-left col-md-3">
                         <button type="button" onclick="submit()" class="btn btn-primary btn-block">編集</button>
                     </div>
                 </div>
             </div>
         </div>
        {{Form::close()}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {{Form::open(['route' => [ 'exercise.delete.complete', $exercise->exercise_id ], 'onsubmit' => "return false;"])}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">削除しますか？</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ $exercise->question }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">キャンセル</button>
                            <button type="button" onclick="submit()" class="btn btn-danger">削除</button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
    </div>
@endsection

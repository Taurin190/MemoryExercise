@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($errors) > 0)
        <div class="row">
            <div class="offset-md-2 col-md-10 mx-auto ">
                <div class="mx-3 col-md-11 float-right alert alert-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
        </div>
        @endif
        {{Form::open(['route' => [ 'exercise.edit.confirm', $exercise->getExerciseId()], 'onsubmit' => "return false;"])}}
         <div class="row justify-content-center">
             <div class="card col-md-10 py-5 px-5">
                 <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題編集</h2>
                 <div class="col-md-12 px-0 align-items-start mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                    <label class="pt-2 my-2 form-label control-label" for="InputQuestion">質問</label>
                    <div>
                        <textarea rows="2"
                               class="form-control"
                               id="InputQuestion"
                               name="question"
                               placeholder="パンはパンでも食べられないパンは何だ？"
                        >{{ $exercise->getQuestion() }}</textarea>
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
                        >{{ $exercise->getAnswer() }}</textarea>
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
    </div>
@endsection

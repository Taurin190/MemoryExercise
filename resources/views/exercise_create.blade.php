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
        {{Form::open(['route' => [ 'exercise.confirm'], 'onsubmit' => "return false;"])}}
         <div class="row">
             <div class="col-md-10 mx-auto">
                 <h2 class="mb-3">問題作成</h2>
             </div>
             <div class="col-md-10 align-items-start py-2 mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                <label class="pt-2 my-2 control-label" for="InputQuestion">質問</label>
                <div class="">
                    <textarea rows="2"
                           class="form-control"
                           id="InputQuestion"
                           name="question"
                           placeholder="パンはパンでも食べられないパンは何だ？"
                    >{{ $question }}</textarea>
                    @if(!empty($errors->first('question')))
                    <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
            <div class="align-items-start py-2 col-md-10 mx-auto form-group @if(!empty($errors->first('answer'))) has-error @endif">
                <label class="pt-2 py-2 control-label" for="InputAnswer">答え</label>
                <div class="">
                    <textarea rows="2"
                           class="form-control "
                           id="InputAnswer"
                           name="answer"
                           placeholder="フライパン"
                    >{{ $answer }}</textarea>
                    @if(!empty($errors->first('answer')))
                        <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
             <div class="py-2 form-group col-md-10 mx-auto">
                 <label class="control-label py-2">公開設定</label>
                 <div class="">
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
             <div class="col-md-10 mx-auto form-group">
                 <label class="py-2 control-label" for="InputAnswer">カテゴリ</label>
                 <label-search-component></label-search-component>
             </div>
             <div class="py-2 col-md-10 mx-auto form-group">
                 <div class="px-0 col-md-3 float-left">
                     <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
                 </div>
                 <div class="px-0 mx-2 float-left col-md-3">
                     <button type="button" onclick="submit()" class="btn btn-primary btn-block">作成</button>
                 </div>
             </div>
         </div>
        {{Form::close()}}
    </div>
@endsection

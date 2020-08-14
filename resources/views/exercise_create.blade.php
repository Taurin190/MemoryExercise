@extends('layouts.app')

@section('content')
    <div class="container py-4">

        @if(count($errors) > 0)
        <div class="row">
            <div class="col-md-8 mx-auto alert alert-danger alert-dismissible fade show">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
        @endif
        <form onsubmit="return false;" method="POST" action="{{ route('exercise.confirm') }}" accept-charset="UTF-8">
        {{--{{Form::open(['route' => [ 'exercise.confirm']])}}--}}
         <div class="row">
            <div class="d-flex align-items-start py-2 col-md-10 mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                <label class="pt-2 float-left col-md-2 control-label text-right" for="InputQuestion">問題の質問</label>
                <div class="float-left col-md-10">
                    <textarea rows="2"
                           class="form-control"
                           id="InputQuestion"
                           name="question"
                           placeholder="質問"
                    >{{ $question }}</textarea>
                    @if(!empty($errors->first('question')))
                    <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-start py-2 col-md-10 mx-auto form-group @if(!empty($errors->first('answer'))) has-error @endif">
                <label class="pt-2 col-md-2 float-left control-label text-right" for="InputAnswer">問題の答え</label>
                <div class="col-md-10 float-left">
                    <textarea rows="2"
                           class="form-control "
                           id="InputAnswer"
                           name="answer"
                           placeholder="答え"
                    >{{ $answer }}</textarea>
                    @if(!empty($errors->first('answer')))
                        <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
             <div class="py-2 col-md-10 mx-auto form-group">
                 <label class="col-md-2 float-left control-label text-right" for="InputAnswer">公開設定</label>
                 <div class="col-md-10 float-left">
                     <input type="radio"
                            class=""
                            name="public"
                            value="public"
                            checked="checked"
                     >
                     <label for="contactChoice1">公開</label>
                     <input type="radio"
                            class=""
                            name="public"
                            value="private"
                     >
                     <label for="contactChoice1">非公開</label>
                 </div>
             </div>
             <div class="py-2 col-md-10 mx-auto form-group">
                 <label class="py-2 col-md-2 float-left control-label text-right" for="InputAnswer">カテゴリ</label>
                 <category-search-component></category-search-component>
             </div>
             <div class="py-2 col-md-10 mx-auto form-group">
                 <div class="offset-md-2 col-md-3 float-left">
                     <button type="button" onclick="history.back()" class="btn btn-outline-secondary btn-block">戻る</button>
                 </div>
                 <div class="float-left col-md-3">
                     <button type="button" onclick="submit()" class="btn btn-primary btn-block">作成</button>
                 </div>
             </div>
         </div>
        {{--{{Form::close()}}--}}
        </form>
    </div>
@endsection

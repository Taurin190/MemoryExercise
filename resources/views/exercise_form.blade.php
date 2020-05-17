@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($errors) > 0)
            <div class="m-2 col-sm-10 alert alert-danger alert-dismissible fade show">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        {{Form::open(['route' => [ 'exercise.confirm']])}}
            <div class="form-group @if(!empty($errors->first('question'))) has-error @endif">
                <label class="col-sm-2 control-label" for="InputQuestion">問題の質問</label>
                <div class="col-sm-10">
                    <input type="text"
                           class="form-control "
                           id="InputQuestion"
                           name="question"
                           placeholder="質問"

                    >
                    @if(!empty($errors->first('question')))
                    <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group @if(!empty($errors->first('answer'))) has-error @endif">
                <label class="col-sm-2 control-label" for="InputAnswer">問題の答え</label>
                <div class="col-sm-10">
                    <input type="text"
                           class="form-control "
                           id="InputAnswer"
                           name="answer"
                           placeholder="答え"

                    >
                    @if(!empty($errors->first('answer')))
                        <span class="text-danger">{{ $error }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-block">送信</button>
                </div>
            </div>
        {{Form::close()}}
    </div>
@endsection

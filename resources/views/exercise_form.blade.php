@extends('layouts.app')

@section('content')
    <div class="container">
        {{Form::open(['route' => [ 'exercise.confirm']])}}
            <div class="form-group">
                <label class="col-sm-2 control-label" for="InputQuestion">問題の質問</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="InputQuestion" name="question" placeholder="質問">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="InputAnswer">問題の答え</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="InputAnswer" name="answer" placeholder="答え">
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

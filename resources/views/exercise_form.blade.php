@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="InputName">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="InputName" placeholder="タイトル">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="InputQuestion">Question</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="InputQuestion" placeholder="質問">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="InputAnswer">Answer</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="InputAnswer" placeholder="答え">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-block">送信</button>
                </div>
            </div>
        </form>
    </div>
@endsection

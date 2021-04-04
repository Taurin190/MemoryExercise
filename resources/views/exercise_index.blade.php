@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(count($exercise_list) == 0)
                問題集が存在しません。
            @else
                <div>
                   <span>{{ $count }} 件</span>
                </div>
                @if(isset($user_id))
                    <exercise-append-component :user_id='@json($user_id)' :exercise_list='@json($exercise_list)'
                                               :count='@json($count)'></exercise-append-component>
                @else
                    <exercise-append-component :exercise_list='@json($exercise_list)'
                                               :count='@json($count)'></exercise-append-component>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

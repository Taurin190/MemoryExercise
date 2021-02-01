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
            {{--@foreach($exercise_list as $exercise)--}}
                {{--<div class="col-md-3 py-2 px-1 float-left">--}}
                    {{--<div class="card workbook-card">--}}
                        {{--<a class="text-body text-decoration-none" href="{{route('exercise.detail', $exercise->exercise_id)}}">--}}
                            {{--<div class="card-body">--}}
                                {{--<h4 class="card-title">{{ $exercise->question }}</h4>--}}
                                {{--<p class="text-break explanation">{!! nl2br(e($exercise->answer)) !!}</p>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                        {{--@if(isset($user_id) && $exercise->user->id == $user_id)--}}
                            {{--<a class="text-decoration-none" href="{{route('exercise.edit', $exercise->exercise_id)}}">--}}
                                {{--<div class="workbook-edit">--}}
                                    {{--<i class="fas fa-pen"></i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endforeach--}}
                <exercise-append-component :exercise_list='@json($exercise_list)' :count='@json($count)'></exercise-append-component>
            @endif
        </div>
    </div>
</div>
@endsection

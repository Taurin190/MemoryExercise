@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(count($workbooks) == 0)
                問題集が存在しません。
            @else
            <div>
                <span>{{ count($workbooks) }} 件</span>
            </div>
            @foreach($workbooks as $workbook)
            <div class="col-md-3 py-2 px-1 float-left">
                <div class="card workbook-card">
                    <a class="text-body text-decoration-none"
                       href="{{route('workbook.detail', $workbook->workbook_id)}}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $workbook->title }}</h4>
                        <p class="text-break explanation">{!! nl2br(e($workbook->explanation)) !!}</p>
                    </div>
                    </a>
                    @if(isset($user_id) && $workbook->user_id == $user_id)
                        <a class="text-decoration-none" href="{{route('workbook.edit', $workbook->workbook_id)}}">
                        <div class="workbook-edit">
                            <i class="fas fa-pen"></i>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

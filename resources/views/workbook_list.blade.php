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
                    <a class="text-body text-decoration-none" href="/workbook/{{$workbook->getWorkbookId()}}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $workbook->getTitle() }}</h4>
                        <p class="text-break explanation">{!! nl2br(e($workbook->getExplanation())) !!}</p>
                    </div>
                    </a>
                    <a class="text-decoration-none" href="/workbook/{{$workbook->getWorkbookId()}}/edit">
                        <div class="workbook-edit">
                            <i class="fas fa-pen"></i>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

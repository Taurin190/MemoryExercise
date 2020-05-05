@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($workbooks) == 0)
                問題集が存在しません。
            @endif
            @foreach($workbooks as $workbook)
            <div class="card">
                <a href="/workbook/{{$workbook->getWorkbookId()}}">
                <div class="card-header">{{ $workbook->getTitle() }}</div>
                <div class="card-body">
                        {{ $workbook->getExplanation() }}
                </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

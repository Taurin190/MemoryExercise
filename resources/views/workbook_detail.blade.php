@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{ $workbook->getTitle() }}</h2>
            @if(!empty($workbook->getExplanation()))
                <span>{{ $workbook->getExplanation() }}</span>
            @endif

        </div>
    </div>
</div>
@endsection

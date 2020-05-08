@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <workbook-component :workbook='@json($workbook_array)'></workbook-component>
        <div class="col-md-8">
            @php($problem_count = 0)
            {{Form::open(['route' => [ 'workbook.complete', $workbook->getWorkbookId()]])}}

            <div>
                <button class="btn btn-primary btn-block">回答完了</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

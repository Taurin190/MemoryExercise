@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{Form::open(['route' => [ 'workbook.complete', $workbook->getWorkbookId()]])}}
                <workbook-component :workbook='@json($workbook_array)'></workbook-component>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

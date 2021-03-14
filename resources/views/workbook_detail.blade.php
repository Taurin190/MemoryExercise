@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 card pt-5 px-5">
            {{Form::open(['route' => [ 'workbook.result', $workbook->getWorkbookId()]])}}
                <workbook-component :workbook='@json($workbook_array)'></workbook-component>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

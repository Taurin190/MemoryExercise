@extends('layouts.app')

@section('content')
<div class="container">
    @if(count($errors) > 0)
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="col-md-12 float-right alert alert-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="card py-5 px-5 col-md-10">
            <h2 class="mb-2"><i class="fas fa-book-open pr-2"></i>問題集作成</h2>
            {{Form::open(['route' => [ 'workbook.confirm']])}}
            <workbook-create-component :workbook='@json($workbook->toArray())'></workbook-create-component>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@endsection

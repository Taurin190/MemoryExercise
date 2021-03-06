@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' => [ 'workbook.complete']])}}
    <div class="row justify-content-center">
        <div class="card col-md-10 py-5 px-5">
            <h2 class="mb-2"><i class="fas fa-book-open pr-2 pb-4"></i>問題集作成</h2>
            <p>以下の内容を作成してよろしいですか？</p>
            <div>
                <label class="pt-2 my-2 form-label control-label">問題集のタイトル</label>
                <p>{{ $workbook->title }}</p>
                <input type="hidden" name="title" value="{{ $workbook->title }}">
            </div>
            <div>
                <label class="pt-2 my-2 form-label control-label">問題集の説明</label>
                <p>{!! nl2br(e($workbook->explanation)) !!}</p>
                <input type="hidden" name="explanation" value="{{ $workbook->explanation }}">
            </div>
            @isset($exercise_list)
            <div>
                <label class="pt-2 my-2 form-label control-label">問題</label>
                <ul>
                    @foreach($exercise_list as $exercise)
                        <li>{{ $exercise->question }}</li>
                        <input type="hidden" name="exercise[]" value="{{ $exercise->exercise_id }}" />
                    @endforeach
                </ul>
            </div>
            @endisset
            <div class="col-md-12 px-0 py-2 btn-group d-flex" role="group" aria-label="...">
                <button type="button" onclick="history.back()"
                        class="btn btn-outline-secondary btn-block px-0 float-left col-md-3">戻る</button>
                <input type="submit"
                       class="btn btn-outline-primary px-0 mx-2 float-left col-md-3" value="作成" />
            </div>
        </div>
    </div>
    {{Form::close()}}
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    {{Form::open(['route' =>  ['workbook.edit.complete', $workbook->workbook_id]])}}
    <div class="row justify-content-center">
        <div class="card col-md-10 py-5 px-5">
            <h2 class="mb-2"><i class="fas fa-book-open pr-2"></i>問題集編集</h2>
            <p>以下で編集してよろしいですか？</p>
            <div>
                <label class="form-label control-label py-2">問題集のタイトル</label>
                <p>{{ $workbook->title }}</p>
            </div>
            <div>
                <label class="form-label control-label py-2">問題集の説明</label>
                <p>{{ $workbook->explanation }}</p>
            </div>
            @isset($exercise_list)
            <div>
                <label class="form-label control-label py-2">問題</label>
                <ul>
                    @foreach($exercise_list as $exercise)
                        <li>{{ $exercise->question }}</li>
                    @endforeach
                </ul>
            </div>
            @endisset
            <div class="col-md-12 px-0 py-2 btn-group d-flex" role="group" aria-label="...">
                <a href="{{route('workbook.edit', $workbook->workbook_id )}}"
                   class="btn btn-outline-secondary px-0 col-md-3 float-left">戻る</a>
                <input type="submit"
                       class="btn btn-outline-primary px-0 mx-2 float-left col-md-3" value="作成" />
            </div>
        </div>
    </div>

    {{Form::close()}}
</div>
@endsection

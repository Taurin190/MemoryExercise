@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="row justify-content-center">
             <div class="card col-md-10 py-5 px-5">
                 <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題</h2>
                 @if(isset($user_id) && $exercise->user_id == $user_id)
                 <a class="text-decoration-none" href="{{route('exercise.edit', $exercise->uuid)}}">
                     <div class="exercise-delete">
                         <i class="fas fa-pen delete-icon"></i>
                     </div>
                 </a>
                 @endif
                 <div class="col-md-12 px-0 align-items-start mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                     <div class="exercise-question-container">
                         <p class="py-3 question">{{ $exercise->question }}</p>
                     </div>
                 </div>
                 <div class="align-items-start py-2 col-md-12 px-0 form-group">
                     <div class="exercise-answer-container">
                         <a data-toggle="collapse" href="#collapse-{{ $exercise->uuid }}"
                            aria-controls="collapse-{{ $exercise->uuid }}">解答を表示</a>
                         <div id="collapse-{{ $exercise->uuid }}" class="collapse card">
                             <div class="card-body">
                                 <label class="form-label">解答</label>
                                 <p class="answer">{{ $exercise->answer }}</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="pb-2 form-group col-md-12 px-0">
                     <label class="form-label control-label pb-2">公開設定</label>
                     @if($exercise->permission == 1)
                     <div>
                         <label for="contactChoice1">公開</label>
                     </div>
                     @else
                     <div>
                        <label for="contactChoice1">非公開</label>
                     </div>
                     @endif
                 </div>
                 <div class="col-md-12 form-group px-0">
                     <label class="pb-2 form-label control-label" for="InputAnswer">カテゴリ</label>
                     @if(empty($label_list) || count($label_list) == 0)
                        <p class="py-2">ラベルは登録されていません。</p>
                     @else
                         <label-list-component :label_list='@json($label_list)' :show_close_button="false"></label-list-component>
                     @endif
                 </div>
             </div>
         </div>
    </div>
@endsection

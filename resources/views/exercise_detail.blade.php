@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="row justify-content-center">
             <div class="card col-md-10 py-5 px-5">
                 <h2 class="mb-2"><i class="fas fa-question-circle pr-2"></i>問題</h2>
                 @if(isset($user_id) && $exercise->getUserId() == $user_id)
                 <a class="text-decoration-none" href="{{route('exercise.edit', $exercise->getExerciseId())}}">
                     <div class="exercise-delete">
                         <i class="fas fa-pen delete-icon"></i>
                     </div>
                 </a>
                 @endif
                 <div class="col-md-12 px-0 align-items-start mx-auto form-group @if(!empty($errors->first('question'))) has-error @endif">
                     <div class="exercise-question-container">
                         <p class="py-3 question">{{ $exercise->getQuestion() }}</p>
                     </div>
                 </div>
                 <div class="align-items-start py-2 col-md-12 px-0 form-group">
                     <div class="exercise-answer-container">
                         <a data-toggle="collapse" href="#collapse-{{ $exercise->getExerciseId() }}"
                            aria-controls="collapse-{{ $exercise->getExerciseId() }}">解答を表示</a>
                         <div id="collapse-{{ $exercise->getExerciseId() }}" class="collapse card">
                             <div class="card-body">
                                 <label class="form-label">解答</label>
                                 <p class="answer">{{ $exercise->getAnswer() }}</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="pb-2 form-group col-md-12 px-0">
                     <label class="form-label control-label pb-2">公開設定</label>
                     @if($exercise->getPermission() == 1)
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
                         {{--<div class="py-2">--}}
                             {{--@foreach($label_list as $label)--}}
                             {{--<div class="px-2 py-1 mr-1 mb-2 badge badge-primary">--}}
                                 {{--<span>{{ $label }}</span>--}}
                                 {{--<input type="hidden" name="label[]" value="{{ $label }}" />--}}
                                 {{--<a style="color: white;" href="#" @click="removeTag(index)">x</a>--}}
                             {{--</div>--}}
                             {{--@endforeach--}}
                         {{--</div>--}}
                     @endif
                 </div>
             </div>
         </div>
    </div>
@endsection

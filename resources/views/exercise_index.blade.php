@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h2>学習記録</h2>
                <div>
                    <span>目標</span>
                </div>
            </div>
            <div>
                <h2>list</h2>
                <div>
                    <ul class="list-group">
                        @foreach($exercise_list as $exercise)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $exercise->question }}
                            @if($exercise_history_list)
                                <span class="badge badge-primary badge-pill">
                                    @if(isset($exercise_history_list[$exercise->exercise_id]))
                                        {{ $exercise_history_list[$exercise->exercise_id] }}
                                    @else
                                        0
                                    @endif
                                </span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

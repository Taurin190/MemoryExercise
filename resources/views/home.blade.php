@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-7 float-md-left">
                        <h2><i class="pb-4 pr-2 fas fa-pen"></i>学習記録</h2>
                        <div>
                            <div>
                                <label class="h5 pl-0 float-left col-md-6">今月の学習問題数</label>
                                <p class="float-left col-md-4 offset-2">{{ $study_summary->exerciseCountInMonth }}問</p>
                            </div>
                            <div>
                                <label class="h5 pl-0 float-left col-md-6">累計学習問題数</label>
                                <p class="float-left col-md-4 offset-2">{{ $study_summary->totalExerciseCount }}問</p>
                            </div>
                            <div>
                                <label class="h5 pl-0 float-left col-md-6">累計学習日数</label>
                                <p class="float-left col-md-4 offset-2">{{ $study_summary->totalStudyDays }}日</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 float-md-left">
                        <div>
                            <img class="col-md-12" src="./no_image_profile.jpg"/>
                            <p class="py-2 col-md-12 text-center">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <study-history-graph-component
                            :study-count='@json($graph_data)'></study-history-graph-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

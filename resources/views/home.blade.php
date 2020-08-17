@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-4">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-7 float-md-left">
                        <h2>学習目標</h2>
                        <p>目標: AWS Solution Architect合格</p>
                        <p>今日の学習目標: 30問</p>
                        <hr>
                        <h3><i class="fas fa-pen"></i>学習記録</h3>
                        <table>
                            <tbody>
                                <tr>
                                    <th>今月の学習問題数</th>
                                    <td>10問</td>
                                </tr>
                                <tr>
                                    <th>先月の学習問題数</th>
                                    <td>10問</td>
                                </tr>
                                <tr>
                                    <th>累計学習問題数</th>
                                    <td>100問</td>
                                </tr>
                                <tr>
                                    <th>累計学習日数</th>
                                    <td>100日</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5 float-md-left">
                        <div>
                            <img class="col-md-12" src="./no_image_profile.jpg"/>
                            <p>ユーザ名</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <study-history-graph-component></study-history-graph-component>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h2>タイムライン</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

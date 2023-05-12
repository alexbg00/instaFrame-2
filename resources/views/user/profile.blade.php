@extends('layouts.app')


@section('content')
<style>
    .user-info{
        margin-top: 20px;
        height: 200px;
        float: left;
        padding-top: 20px;
        padding-left: 15px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-user">
                @if ($user->image)

                <div class="container-avatar" style="width: 200px; border-radius:900px; overflow:hidden; height:200px; float:left">
                    <img
                    {{-- "data:image/png;base64,{{ $user->image }}" --}}
                    src= "data:image/png;base64,{{ $user->image }}"
                    style="width: 100%">

                </div>

                @endif

                <div class="user-info">
                    <h1>{{ '@'.$user->nick }}</h1>
                    <h2>{{ $user->name.' '.$user->surname }}</h2>
                    <p>{{ 'Se unió: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <hr>
            <div class="clearfix"></div>

            @foreach ($user->images as $image)
                @include('includes.image', ['image' => $image])
            @endforeach
        </div>
    </div>
</div>
@endsection


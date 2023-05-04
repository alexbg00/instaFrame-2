@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-user">
                @if ($user->image)
                <div class="container-avatar">
                    {{-- imprimir la foto de perfil una sola vez --}}
                    <img src="data:image/png;base64,{{ $user->image }}">

                </div>
                @endif
                <div class="user-info">
                    <h1>{{ '@'.$user->nick }}</h1>
                    <h2>{{ $user->name.' '.$user->surname }}</h2>
                    <p>{{ 'Se unió: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                </div>
            </div>
            @foreach ($user->images as $image)
                @include('includes.image', ['image' => $image])
            @endforeach
        </div>
    </div>
</div>
@endsection


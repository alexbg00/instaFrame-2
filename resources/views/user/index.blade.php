@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Usuarios</h1>
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($users as $user)
                    <div class="profile-user mb-3">
                        @if ($user->image)
                            <div class="container-avatar" style="width: 200px; height: 200px; border-radius: 900px; overflow: hidden; float: left;">
                                <img src="data:image/png;base64,{{ $user->image }}" style="width: 100%;" class="img-fluid img-thumbnail">
                            </div>
                        @endif
                        <div class="user-info ml-5">
                            <h2>{{ '@'.$user->nick }}</h2>
                            <h3>{{ $user->name.' '.$user->surname }}</h3>
                            <p>{{ 'Se unió: '.\FormatTime::LongTimeFilter($user->created_at) }}</p>
                            <a href="{{ route('profile',['id'=>$user->id]) }}" class="btn btn-success">Ver perfil</a>
                            <div class="clearfix"></div>
                            <hr>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

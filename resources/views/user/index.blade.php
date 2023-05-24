@extends('layouts.app')

@section('content')

<script>
    url = window.location.href;
    /* url inicial sin las / */
    url = url.split('/');
    url = url[0] + '//' + url[2];
    console.log(url);


    function buscador(){
        console.log(document.getElementById('buscador'));
        $('#buscador').attr('action', url+'/gente/'+$('#buscador #search').val());
    }



</script>
<div class="container">
    <h1>Ver Usuarios</h1>

    <form method="GET" action="{{ route('user.index') }}" id="buscador">
        @csrf
        <div class="row">
            <div class="form-group col">
                <input type="text" id="search" class="form-control" name="search" placeholder="Buscar usuario"
                        onchange="buscador()" />
            </div>
            <div class="form-group col">
                <button class="btn btn-success" onclick="buscador()">Buscar</button>
            </div>
        </div>
    </form>

    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($users as $user)
            <div class="profile-user mb-3">
                @if ($user->image)
                <div class="container-avatar"
                    style="width: 200px; height: 200px; border-radius: 900px; overflow: hidden; float: left;">
                    <img src="data:image/png;base64,{{ $user->image }}" style="width: 100%;"
                        class="img-fluid img-thumbnail">
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

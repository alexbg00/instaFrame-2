@extends('layouts.app')


@section('content')

<script>
    url = window.location.href;
/* url inicial sin las / */
url = url.split('/');
url = url[0] + '//' + url[2];
/* url inicial sin las / */

window.addEventListener('load', function () {

function like(){
$('.btn-like').on('click',function(event){
    event.stopPropagation();

    $(this).addClass('btn-dislike').unbind('click').removeClass('btn-like');
    $(this).attr('src', url+'/icons/heart-rojo.png');

    $.ajax({
        url: '/like/' + $(this).data('id'),
        type: 'GET',
        success: function (response) {
            if (response.like) {
                console.log('Has dado like a la publicacion');
            } else {
                console.log('Error al dar like');
            }
        }
    });
    dislike();
})
}
like();



function dislike() {
    $('.btn-dislike').unbind('click').on('click',function(event){
        event.stopPropagation();
        $(this).addClass('btn-like').removeClass('btn-dislike');
        $(this).attr('src', url+'/icons/heart-gris.png');

        $.ajax({
            url: '/dislike/' + $(this).data('id'),
            type: 'GET',
            success: function (response) {
                if (response.like) {
                    console.log('Has dado dislike a la publicacion');
                }else{
                    console.log('Error al dar dislike');
                }
            }
        });
        like();

})
}
dislike();
});





</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <div class="card" style="margin-bottom: 30px">
                <div class="card-header">
                    <div>
                        <p style="font-weight:bold ">
                            <img src="data:image/png;base64,{{ $image->user->image }}"
                                style="width: 3em; height:3em; border-radius:900px; overflow:hidden"
                                class="img-fluid img-thumbnail">
                            {{ $image->user->name." " . $image->user->surname." | @". $image->user->nick }}
                        </p>
                    </div>
                    <div class="card-body">
                        <img src="data:image/png;base64,{{ $image->image_path }}"
                            style="max-height:500px; overflow:hidden; width:100%; " class="img-fluid img-thumbnail">
                    </div>

                    <div class="description" style="padding:20px; padding-bottom:0px;">
                        <span>{{ '@'.$image->user->nick }}</span>
                        <span class="nickname-date">{{ ' | '.\FormatTime::LongTimeFilter($image->created_at) }}</span>

                        <p>{{ $image->description }}</p>
                    </div>

                    <div class="likes" style="float:left; padding-left:20px; padding:right:10px ">
                        <?php $user_like = false; ?>

                        @foreach ($image->likes as $like)

                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif

                        @endforeach
                        @if($user_like)
                        <img style="width:20px; cursor: pointer;" src="{{ asset('icons/heart-rojo.png') }}"
                            data-id="{{ $image->id }}" class="btn-dislike" />

                        @else
                        <img style="width:20px; cursor: pointer;" src="{{ asset('icons/heart-gris.png') }}"
                            data-id="{{ $image->id }}" class="btn-like" />

                        @endif
                        {{ count($image->likes) }}

                    </div>

                    <div class="clearfix"></div>
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions" style="margin:10px ">
                        <a href="{{ route('image.edit', ['id' => $image->id]) }}" class="btn btn-primary">Actualizar</a>
                        
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                           Eliminar
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Estas seguro de eliminar la imagen?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        Si eliminas esta imagen no podras recuperarla, ¿Estas seguro?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <a href="{{ route('image.delete', ['id'=> $image->id]) }}" class="btn btn-danger">Borrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <br>
                    <div class="clearfix"></div>
                    <h2 style="margin: 20px">Comentarios ({{ count($image->comments) }})</h2>
                    <hr>


                    <div style="padding: 20px">
                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf

                            <input type="hidden" name="image_id" value="{{ $image->id }}" />
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                                @if($errors->has('content'))
                                <span role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                            </p>

                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                        <hr>

                        @foreach ($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{ '@'.$comment->user->nick }}</span>
                            <span class="nickname-date">{{ ' | '.\FormatTime::LongTimeFilter($comment->created_at)
                                }}</span>
                            <p>{{ $comment->content }}

                                @if (Auth::check() && ($comment->user_id == Auth::user()->id ||
                                $comment->image->user_id == Auth::user()->id))

                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}"
                                    class="btn btn-sm btn-danger">
                                    🗑️
                                </a>
                            </p>
                            @endif
                        </div>

                        @endforeach
                    </div>

                    </a>
                </div>
            </div>

        </div>

        @endsection

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin-bottom: 30px">
                <div class="card-header" >
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
                        <img style="width:20px" src="{{ asset('icons/heart-gris.png') }}">
                    </div>
                    <br>
                        <div class="clear-fix"></div>
{{--                     <a href="" class="btn btn-sm btn-warning" style="margin:20px; margin-top:0px; margin-left:10px; padding-right:5px" >
 --}}                        <h2 style="margin: 20px">Comentarios ({{ count($image->comments) }})</h2><hr>

                    <div style="padding: 20px">
                        <form method="POST" action="" >
                            @csrf

                            <input type="hidden" name="image_id" value="{{ $image->id }}"/>
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                            </p>
                            <button type="submit" class="btn btn-success">
                                Enviar
                            </button>
                        </form>
                    </div>

                    </a>
                </div>
            </div>

</div>

@endsection

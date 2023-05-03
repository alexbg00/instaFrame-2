@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($images as $image)
            <div class="card" style="margin-bottom: 30px">
                <div class="card-header">
                    <p style="font-weight:bold ">
                        <img src="data:image/png;base64,{{ $image->user->image }}"
                            style="width: 3em; height:3em; border-radius:900px; overflow:hidden"
                            class="img-fluid img-thumbnail">
                        <a href="{{ route('image.detail', ['id' => $image->id]) }}" style="color: #444; text-decoration: none">
                        {{ $image->user->name." " . $image->user->surname." | @". $image->user->nick }}
                    </p>
                        </a>
                    <div class="card-body">
                        <img src="data:image/png;base64,{{ $image->image_path }}"
                            style="max-height:400px; overflow:hidden; width:100%; " class="img-fluid img-thumbnail">
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
                        <img style="width:20px" src="{{ asset('icons/heart-rojo.png') }}" class="btn-dislike">

                        @else
                        <img style="width:20px" src="{{ asset('icons/heart-gris.png') }}" class="btn-like">

                        @endif
                        {{ count($image->likes) }}

                    </div>


                    <a href="" class="btn btn-sm btn-warning" style="margin:20px; margin-top:0px; margin-left:10px; padding-right:5px" >
                        Comentarios ({{ count($image->comments) }})

                    </a>
                </div>
            </div>
            @endforeach

    </div>
    {{-- poner paginacion con estilos --}}
    <div class="clearfix"></div>
    {{ $images->links() }}
    {{-- traducir al español el paginate --}}


</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Mis Likes </h1>

            @foreach($likes as $like)
            <div class="card" style="margin-bottom: 30px">
                <div class="card-header">
                    <p style="font-weight:bold ">
                        <img src="data:image/png;base64,{{ $like->user->image }}"
                            style="width: 3em; height:3em; border-radius:900px; overflow:hidden"
                            class="img-fluid img-thumbnail">
                        <a href="{{ route('image.detail', ['id' => $like->image->id]) }}" style="color: #444; text-decoration: none">
                        {{ $like->image->user->name." " . $like->image->user->surname." | @". $like->image->user->nick }}
                    </p>
                        </a>
                    <div class="card-body">
                        <img src="data:image/png;base64,{{ $like->image->image_path }}"
                            style="max-height:400px; overflow:hidden; width:100%; " class="img-fluid img-thumbnail">
                    </div>

                    <div class="description" style="padding:20px; padding-bottom:0px;">
                        <span>{{ '@'.$like->image->user->nick }}</span>
                        <span class="nickname-date">{{ ' | '.\FormatTime::LongTimeFilter($like->image->created_at) }}</span>
                        <p>{{ $like->image->description }}</p>
                    </div>

                    <div class="likes" style="float:left; padding-left:20px; padding-right:10px ">
                        <?php $user_like = false; ?>

                        @foreach ($like->image->likes as $image_like)

                            @if($image_like->user->id == Auth::user()->id)
                            <?php $user_like = true; ?>
                            @endif

                        @endforeach

                    </div>

                </div>
            </div>

            @endforeach


            <!-- PAGINACION -->
            <div class="clearfix"></div>
            {{ $likes->links() }}

        </div>
    </div>
</div>

@endsection



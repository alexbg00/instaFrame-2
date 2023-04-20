@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($images as $image)

            <div class="card">
                <div class="card-header">
                    <img src="data:image/png;base64,{{ $image->user->image }}" style="width: 3em; height:3em; border-radius:900px; overflow:hidden"
                                                                                        class="img-fluid img-thumbnail">
                    {{ $image->user->name." " . $image->user->surname }}
                    

                </div>


                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection

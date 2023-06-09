@extends('layouts.app')

@section('content')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Subir nueva imagen</div>

            <div class="card-body">
                <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group row">
                        <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="image_path" id="image_path" required>

                                @if ($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                    @endif

                            </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right">Descripcion</label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="description" id="description" required></textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                            </div>
                    </div>

                    <br>
                    <div class="form-group row">
                        <label for="filtro" class="col-md-3 col-form-label text-md-right">Filtro - foto</label>
                            <div class="col-md-7">
                                <select name="filtro" id="filtro" onchange="hadleChangeFilter()">
                                    <option value="normal">Normal</option>
                                    <option value="sepia">Sepia</option>
                                    <option value="negativo">Negativo</option>
                                </select>

                            </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            {{-- previsualizar la imagen a subir --}}

                            <img id="preview" src="#" alt="Previsualización de la imagen" style="display: none; width:350px">

                        </div>
                    </div>

                    <br>
                    <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit" class="btn btn-primary" value="Subir imagen">
                            </div>
                    </div>




                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<style>
    .filter-normal{
        filter: none;
    }

    .filter-sepia{
        filter: sepia(100%);
    }

    .filter-negativo{
        filter: invert(100%);
    }
</style>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('image_path').addEventListener('change', previewImage);

    function hadleChangeFilter(){
        const filter = document.getElementById('filtro').value;
        const preview = document.getElementById('preview');

        if(filter == 'sepia'){
            preview.className = 'filter-sepia';
        }else if(filter == 'negativo'){
            preview.className = 'filter-negativo';
        }else{
            preview.className = 'filter-normal';
        }

    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

@endsection

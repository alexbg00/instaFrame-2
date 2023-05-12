
@php
/* descodificar una imagen en base 64 desde la base de datos */
$imagen = Auth::user()->image;
@endphp
@if (Auth::user()->image)
<div class="row mb-3">
    <label for="image_path" class="col-md-4 col-form-label text-md-end"></label>
    <div class="col-md-6">
        <div class="card" style="width: 18rem;">
            <div class="container-avatar">
            <img src="data:image/png;base64,{{ $imagen }}" class="card-img-top" alt="...">
            </div>
        </div>
    </div>
</div>
</div>
@endif


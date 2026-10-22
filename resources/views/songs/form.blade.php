{{-- Formulario compartido por create y edit. Recibe: $artistas y $seleccionados --}}
@csrf

<div class="form-group">
    <label for="title">Título *</label>
    <input type="text" name="title" id="title" maxlength="255" required
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $cancion->title ?? '') }}" placeholder="Nombre de la canción">
    @error('title')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="album">Álbum</label>
            <input type="text" name="album" id="album" maxlength="255"
                   class="form-control @error('album') is-invalid @enderror"
                   value="{{ old('album', $cancion->album ?? '') }}" placeholder="Opcional">
            @error('album')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="genre">Género</label>
            <input type="text" name="genre" id="genre" maxlength="100"
                   class="form-control @error('genre') is-invalid @enderror"
                   value="{{ old('genre', $cancion->genre ?? '') }}" placeholder="Rock, pop, balada…">
            @error('genre')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="duration_in_seconds">Duración en segundos</label>
            <input type="number" name="duration_in_seconds" id="duration_in_seconds" min="0"
                   class="form-control @error('duration_in_seconds') is-invalid @enderror"
                   value="{{ old('duration_in_seconds', $cancion->duration_in_seconds ?? '') }}" placeholder="Ej. 245">
            @error('duration_in_seconds')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="release_date">Fecha de lanzamiento</label>
            <input type="date" name="release_date" id="release_date"
                   class="form-control @error('release_date') is-invalid @enderror"
                   value="{{ old('release_date', isset($cancion) && $cancion->release_date ? $cancion->release_date->format('Y-m-d') : '') }}">
            @error('release_date')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

{{-- Relación N:M: un select múltiple que se guarda con sync() --}}
<div class="form-group">
    <label for="artist_ids">Artistas</label>
    <select name="artist_ids[]" id="artist_ids" multiple size="6"
            class="form-control @error('artist_ids') is-invalid @enderror">
        @foreach ($artistas as $artista)
            <option value="{{ $artista->id }}"
                {{ in_array($artista->id, $seleccionados ?? []) ? 'selected' : '' }}>
                {{ $artista->name }}
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">
        Mantén pulsada la tecla Ctrl (Cmd en Mac) para elegir varios artistas.
    </small>
    @error('artist_ids')
        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

{{-- El input oculto hace que un checkbox sin marcar envíe 0 --}}
<div class="custom-control custom-checkbox mb-2">
    <input type="hidden" name="status" value="0">
    <input type="checkbox" name="status" id="status" value="1" class="custom-control-input"
           {{ old('status', $cancion->status ?? true) ? 'checked' : '' }}>
    <label for="status" class="custom-control-label">Canción activa</label>
</div>

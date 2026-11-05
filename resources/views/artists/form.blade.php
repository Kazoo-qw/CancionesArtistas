{{-- Formulario compartido por create y edit --}}
@csrf

<div class="form-group">
    <label for="name">Name *</label>
    <input type="text" name="name" id="name" maxlength="255" required
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $artist->name ?? '') }}" placeholder="Artist name">
    @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" maxlength="100"
                   class="form-control @error('genre') is-invalid @enderror"
                   value="{{ old('genre', $artist->genre ?? '') }}" placeholder="Rock, pop, ballad…">
            @error('genre')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" maxlength="100"
                   class="form-control @error('country') is-invalid @enderror"
                   value="{{ old('country', $artist->country ?? '') }}" placeholder="Colombia">
            @error('country')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="bio">Biography</label>
    <textarea name="bio" id="bio" rows="3"
              class="form-control @error('bio') is-invalid @enderror"
              placeholder="Short description of the artist">{{ old('bio', $artist->bio ?? '') }}</textarea>
    @error('bio')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="image_path">Image path</label>
    <input type="text" name="image_path" id="image_path" maxlength="255"
           class="form-control @error('image_path') is-invalid @enderror"
           value="{{ old('image_path', $artist->image_path ?? '') }}" placeholder="artists/photo.jpg">
    @error('image_path')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

{{-- El input oculto hace que un checkbox sin marcar envíe 0 --}}
<div class="custom-control custom-checkbox mb-2">
    <input type="hidden" name="status" value="0">
    <input type="checkbox" name="status" id="status" value="1" class="custom-control-input"
           {{ old('status', $artist->status ?? true) ? 'checked' : '' }}>
    <label for="status" class="custom-control-label">Active artist</label>
</div>

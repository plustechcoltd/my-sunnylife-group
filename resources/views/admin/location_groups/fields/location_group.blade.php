<div class="mb-3">
    <div class="form-group">
        <label class="form-label fw-semibold label_required">医療グループ名</label>
        <div class="form-control-feedback mb-3">
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', @$location_group->name ) }}" name="name"/>
        </div>
        @if($errors->has('name'))
            <div class="validation-invalid-label">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div class="mb-3">
    <div class="form-group">
        <label class="form-label fw-semibold">並び順</label>
        <div class="form-control-feedback mb-3">
            <input type="text"
                   class="form-control @error('sortno') is-invalid @enderror"
                   value="{{ old('sortno', @$location_group->sortno) }}" name="sortno"/>
        </div>
        @if($errors->has('sortno'))
            <div class="validation-invalid-label">{{ $errors->first('sortno') }}</div>
        @endif
    </div>
</div>
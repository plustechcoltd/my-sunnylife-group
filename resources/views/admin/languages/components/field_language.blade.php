<div class="mb-3">
    <div class="form-group">
        <label class="form-label">{{ __('label.columns.languages.code') }}</label>
        <div class="form-control-feedback mb-3">
            <input type="text"
                class="form-control @if($errors->has('code')) is-invalid @endif"
                name="code"
                value="{{ old('code', $language->code) }}">
        </div>
        @if($errors->has('code'))
            <div class="validation-invalid-label">{{$errors->first('code')}}</div>
        @endif
    </div>
</div>
<div class="mb-3">
    <div class="form-group">
        <label class="form-label">{{ __('label.columns.languages.flag') }}</label>
        <div class="form-control-feedback mb-3">
            <input type="text"
                class="form-control @if($errors->has('flag')) is-invalid @endif"
                name="flag"
                value="{{ old('flag', $language->flag) }}">
        </div>
        @if($errors->has('flag'))
            <div class="validation-invalid-label">{{$errors->first('flag')}}</div>
        @endif
    </div>
</div>
<div class="mb-3">
    <div class="form-group">
        <label class="form-label">{{ __('label.columns.languages.label') }}</label>
        <div class="form-control-feedback mb-3">
            <input type="text"
                class="form-control @if($errors->has('label')) is-invalid @endif"
                name="label"
                value="{{ old('label', $language->label) }}">
        </div>
        @if($errors->has('label'))
            <div class="validation-invalid-label">{{$errors->first('label')}}</div>
        @endif
    </div>
</div>
<div class="mb-3">
    <div class="form-group">
        <div class="form-check form-check-inline form-switch">
            <input name="default_yn" type="checkbox" class="form-check-input" id="sc_li_c" @checked(old('default_yn', $language->default_yn == 'y'))>
            <label class="form-check-label" for="sc_li_c">{{ __('label.columns.languages.default_yn') }}</label>
        </div>
        @if($errors->has('default_yn'))
            <div class="validation-invalid-label">{{$errors->first('default_yn')}}</div>
        @endif
    </div>
</div>
<div class="mb-3">
    <div class="form-group">
        <label class="form-label">{{ __('label.columns.languages.sortno') }}</label>
        <div class="form-control-feedback mb-3">
            <input type="number"
                class="form-control @if($errors->has('sortno')) is-invalid @endif"
                name="sortno"
                value="{{ old('sortno', $language->sortno) }}">
        </div>
        @if($errors->has('sortno'))
            <div class="validation-invalid-label">{{$errors->first('sortno')}}</div>
        @endif
    </div>
</div>
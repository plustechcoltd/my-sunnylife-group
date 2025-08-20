@extends('admin.layouts.master')
@section('title')
    {{ translateWithLocale('edit', 'settings') }}
@endsection
@section('page-header')
    @component('admin.components.page-header')
        @slot('title')
            {{ translateWithLocale('edit', 'settings') }}
        @endslot
        @slot('subtitle')
            {{ __('label.tables.settings') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="fw-bold">
                            <h5>{{ __('label.labels.general_setting') }}</h5>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('label.columns.settings.site_title') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text"
                                               class="form-control @if($errors->has('site_title')) is-invalid @endif"
                                               name="site_title"
                                               value="{{ old('site_title', $settings['site_title'] ?? null) }}">
                                    </div>
                                    @if($errors->has('site_title'))
                                        <div class="validation-invalid-label">{{$errors->first('site_title')}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('label.columns.settings.site_description') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text"
                                               class="form-control @if($errors->has('site_description')) is-invalid @endif"
                                               name="site_description"
                                               value="{{ old('site_description', $settings['site_description'] ?? null) }}">
                                    </div>
                                    @if($errors->has('site_description'))
                                        <div class="validation-invalid-label">{{$errors->first('site_description')}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.logo_login') }}</label>
                                <input type="file" class="form-control file-input-caption-logo_login" name="logo_login" id="logo_login" accept="image/*" >
                                <input type="hidden" name="remove_logo_login" id="remove_logo_login" value="0" >
                                <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 1Mb</div>
                                @error('logo_login')
                                    <div class="validation-invalid-label">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.logo') }}</label>
                                <input type="file" class="form-control file-input-caption-logo" name="logo" id="logo" accept="image/*">
                                <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 1Mb</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.light_logo') }}</label>
                                <input type="file" class="form-control file-input-caption-light_logo" name="light_logo" id="light_logo" accept="image/*">
                                <input type="hidden" name="remove_light_logo" id="remove_light_logo" value="0">
                                <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 1Mb</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.favicon') }}</label>
                                <input type="file" class="form-control file-input-caption-favicon" name="favicon" id="favicon" accept="image/*">
                                <input type="hidden" name="remove_favicon" id="remove_favicon" value="0">
                                <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 1Mb</div>
                                @if($errors->has('favicon'))
                                    <div class="validation-invalid-label">{{$errors->first('favicon')}}</div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3 col-md-3 col-lg-2">
                                    <label class="form-label">{{ __('label.columns.settings.header_background_color') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text" class="form-control colorpicker-custom @if($errors->has('header_background_color')) is-invalid @endif"
                                                name="header_background_color"
                                                data-show-input="true" data-allow-empty="true" data-preferred-format="hex"
                                                value="{{ old('header_background_color', $settings['header_background_color'] ?? config('const.header_background_color_default')) }}">
                                    </div>
                                    @if($errors->has('header_background_color'))
                                        <div class="validation-invalid-label">{{$errors->first('header_background_color')}}</div>
                                    @endif
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-2">
                                    <label class="form-label">{{ __('label.columns.settings.header_text_color') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text" class="form-control colorpicker-custom @if($errors->has('header_text_color')) is-invalid @endif"
                                                name="header_text_color"
                                                data-show-input="true" data-allow-empty="true" data-preferred-format="hex"
                                                value="{{ old('header_text_color', $settings['header_text_color'] ?? config('const.header_text_color_default')) }}">
                                    </div>
                                    @if($errors->has('header_text_color'))
                                        <div class="validation-invalid-label">{{$errors->first('header_text_color')}}</div>
                                @endif
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-2">
                                    <label class="form-label">{{ __('label.columns.settings.navbar_background_color') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text" class="form-control colorpicker-custom @if($errors->has('navbar_background_color')) is-invalid @endif"
                                                name="navbar_background_color"
                                                data-show-input="true" data-allow-empty="true" data-preferred-format="hex"
                                                value="{{ old('navbar_background_color', $settings['navbar_background_color'] ?? config('const.navbar_background_color_default')) }}">
                                    </div>
                                    @if($errors->has('navbar_background_color'))
                                        <div class="validation-invalid-label">{{$errors->first('navbar_background_color')}}</div>
                                    @endif
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-2">
                                    <label class="form-label">{{ __('label.columns.settings.navbar_text_color') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <input type="text" class="form-control colorpicker-custom @if($errors->has('navbar_text_color')) is-invalid @endif"
                                                name="navbar_text_color"
                                                data-show-input="true" data-allow-empty="true" data-preferred-format="hex"
                                                value="{{ old('navbar_text_color', $settings['navbar_text_color'] ?? config('const.navbar_text_color_default')) }}">
                                    </div>
                                    @if($errors->has('navbar_text_color'))
                                        <div class="validation-invalid-label">{{$errors->first('navbar_text_color')}}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.boxed_page') }}</label>
                                <div>
                                    @foreach(config('const.marital_yn') as $value)
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="boxed_page"
                                                   value="{{ $value }}" {{ old('boxed_page', !empty($settings['boxed_page']) && $settings['boxed_page'] == $value ? 'checked' : '') }}>
                                            <span class="form-check-label">{{ __('const.marital_yn.' . $value)}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.display_footer') }}</label>
                                <div>
                                    @foreach(config('const.marital_yn') as $value)
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="display_footer"
                                                   value="{{ $value }}" {{ old('display_footer', !empty($settings['display_footer']) && $settings['display_footer'] == $value ? 'checked' : '') }}>
                                            <span class="form-check-label">{{ __('const.marital_yn.' . $value)}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('label.columns.settings.fixed_footer') }}</label>
                                <div>
                                    @foreach(config('const.marital_yn') as $value)
                                        <label class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="fixed_footer"
                                                   value="{{ $value }}" {{ old('fixed_footer', !empty($settings['fixed_footer']) && $settings['fixed_footer'] == $value ? 'checked' : '') }}>
                                            <span class="form-check-label">{{ __('const.marital_yn.' . $value)}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('label.columns.settings.maintenance_message') }}</label>
                                    <div class="form-control-feedback mb-3">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="ckeditor_classic_empty"
                                                      name="maintenance_message"
                                                      placeholder="Enter your maintenance message!">{{ old('maintenance_message', $settings['maintenance_message'] ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    @error('maintenance_message')
                                    <div class="validation-invalid-label">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('center-scripts')
<script src="{{URL::asset('assets/demo/layout_1/js/vendor/pickers/color/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/demo/layout_1/js/vendor/uploaders/fileinput/fileinput.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/layout_1/js/vendor/editors/ckeditor/ckeditor_classic.js')}}"></script>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        ClassicEditor.create(document.querySelector('#ckeditor_classic_empty'), {
            heading: {
                options: [
                    {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                    {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                    {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'},
                    {model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3'},
                    {model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4'},
                    {model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5'},
                    {model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6'}
                ]
            }
        }).catch(error => {
            console.error(error);
        });

        if (!$().fileinput) {
            console.warn('Warning - fileinput.min.js is not loaded.');
            return;
        }

        // Buttons inside zoom modal
        const previewZoomButtonClasses = {
            // rotate: 'btn btn-light btn-icon btn-sm pe-none',
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        const previewZoomButtonIcons = {
            prev: document.dir == 'rtl' ? '<i class="ph-arrow-right"></i>' : '<i class="ph-arrow-left"></i>',
            next: document.dir == 'rtl' ? '<i class="ph-arrow-left"></i>' : '<i class="ph-arrow-right"></i>',
            rotate: '<i class="ph-arrow-clockwise"></i>',
            toggleheader: '<i class="ph-arrows-down-up"></i>',
            fullscreen: '<i class="ph-corners-out"></i>',
            borderless: '<i class="ph-frame-corners"></i>',
            close: '<i class="ph-x"></i>'
        };

        // File actions
        const fileActionSettings = {
            zoomClass: '',
            zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
            dragClass: 'p-2',
            dragIcon: '<i class="ph-dots-six"></i>',
            removeClass: 'pe-none',
            rotateClass: 'pe-none',
            showRotate: false,
            showRemove: false,
            removeErrorClass: 'text-danger',
            indicatorNew: '<i class="ph-file-plus text-success"></i>',
            indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
            indicatorError: '<i class="ph-x text-danger"></i>',
            indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>'
        };

        const demoPalette = [
            ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
            ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
            ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
            ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
            ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
            ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
            ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
            ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
        ];

        $('.colorpicker-custom').spectrum({
            showPalette: true,
            palette: demoPalette
        });

        $('.file-input-caption-logo_login').fileinput({
            @if(!empty($settings['logo_login']))
            initialPreview: [
                "<img src='{{ Storage::url($settings['logo_login']) }}' class='file-preview-image kv-preview-data'>"
            ],
            @endif
            initialPreviewFileType: 'image',
            previewSettings: {
                image: {width: "400px", height: "auto", 'max-width': "100%", 'max-height': "100%", 'object-fit': 'contain'},
            },
            overwriteInitial: true,
            // allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            msgInvalidFileExtension: 'ファイル「{name}」の拡張子が無効です。サポートされているのは「{extensions}」ファイルのみです。',
            showUpload: false,
            showRotate: false,
            showClose: false,
            browseLabel: '選択',
            removeLabel: '削除',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            browseClass: 'btn btn-primary mt-2 ms-2',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            removeClass: 'ms-2 mt-2 btn btn-light btn-remove-logo_login',
            initialCaption: "ファイルが選択されていません",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            showCaption: false,
            dropZoneEnabled: false
        }).on('filecleared', function(event) {
            $('#remove_logo_login').val('1');
        }).on('fileloaded', function(event) {
            $('#remove_logo_login').val('0');
        });

        $('.file-input-caption-logo').fileinput({
            @if(!empty($settings['logo']))
            initialPreview: [
                "<img src='{{ Storage::url($settings['logo']) }}' class='file-preview-image kv-preview-data'>"
            ],
            @endif
            initialPreviewFileType: 'image',
            previewSettings: {
                image: {width: "400px", height: "auto", 'max-width': "100%", 'max-height': "100%", 'object-fit': 'contain'},
            },
            overwriteInitial: true,
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            msgInvalidFileExtension: 'ファイル「{name}」の拡張子が無効です。サポートされているのは「{extensions}」ファイルのみです。',
            showUpload: false,
            showRotate: false,
            showClose: false,
            browseLabel: '選択',
            removeLabel: '削除',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            browseClass: 'btn btn-primary mt-2 ms-2',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            removeClass: 'ms-2 mt-2 btn btn-light',
            initialCaption: "ファイルが選択されていません",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            showCaption: false,
            dropZoneEnabled: false
        }).on('filecleared', function(event) {
            $('#remove_logo').val('1');
        }).on('fileloaded', function(event) {
            $('#remove_logo').val('0');
        });

        $('.file-input-caption-light_logo').fileinput({
            @if(!empty($settings['light_logo']))
            initialPreview: [
                "<img src='{{ Storage::url($settings['light_logo']) }}' class='file-preview-image kv-preview-data'>"
            ],
            @endif
            initialPreviewFileType: 'image',
            previewSettings: {
                image: {width: "400px", height: "auto", 'max-width': "100%", 'max-height': "100%", 'object-fit': 'contain'},
            },
            overwriteInitial: true,
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            msgInvalidFileExtension: 'ファイル「{name}」の拡張子が無効です。サポートされているのは「{extensions}」ファイルのみです。',
            showUpload: false,
            showRotate: false,
            showClose: false,
            browseLabel: '選択',
            removeLabel: '削除',
            browseClass: 'btn btn-primary mt-2 ms-2',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            removeClass: 'ms-2 mt-2 btn btn-light',
            initialCaption: "ファイルが選択されていません",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            showCaption: false,
            dropZoneEnabled: false
        }).on('filecleared', function(event) {
            $('#remove_light_logo').val('1');
        }).on('fileloaded', function(event) {
            $('#remove_light_logo').val('0');
        });

        $('.file-input-caption-favicon').fileinput({
            @if(!empty($settings['favicon']))
            initialPreview: [
                "<img src='{{ Storage::url($settings['favicon']) }}' class='file-preview-image kv-preview-data'>"
            ],
            @endif
            initialPreviewFileType: 'image',
            previewSettings: {
                image: {width: "400px", height: "auto", 'max-width': "100%", 'max-height': "100%", 'object-fit': 'contain'},
            },
            overwriteInitial: true,
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            msgInvalidFileExtension: 'ファイル「{name}」の拡張子が無効です。サポートされているのは「{extensions}」ファイルのみです。',
            showUpload: false,
            showRotate: false,
            showClose: false,
            browseLabel: '選択',
            removeLabel: '削除',
            browseIcon: '<i class="ph-file-plus me-2"></i>',
            browseClass: 'btn btn-primary mt-2 ms-2',
            layoutTemplates: {
                icon: '<i class="ph-check"></i>'
            },
            removeClass: 'ms-2 mt-2 btn btn-light',
            initialCaption: "ファイルが選択されていません",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings,
            showCaption: false,
            dropZoneEnabled: false
        }).on('filecleared', function(event) {
            $('#remove_favicon').val('1');
        }).on('fileloaded', function(event) {
            $('#remove_favicon').val('0');
        });
    });
</script>
@endsection
<style>
    .file-preview {
        margin-bottom: 0!important;
        border: none!important; /* var(--fi-preview-border) */
    }
    .file-input {
        width: fit-content;
        padding-bottom: 7px;
        border: var(--fi-preview-border);
        padding-right: 8px;
    }
    .file-preview-frame {
        /* margin-right: 8px!important; */
    }
    .file-preview .btn-close {
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border-radius: 50%;
    }
    .file-preview .btn-close {
        background-color: #d9d9d9;
        border-radius: 50%;
        top: 2px!important;
        right: -7px!important;
    }
    .file-preview-frame .kv-file-content {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
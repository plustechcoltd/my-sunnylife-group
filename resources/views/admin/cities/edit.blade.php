@extends('admin.layouts.master')
@section('title')
    {{ $city->name }} | {{ __('label.tables.cities') }}
@endsection

@section('page-header')
    @component('admin.components.breadcrumb')
        @slot('title'){{ $city->name }}@endslot
        @slot('subtitle'){{ __('label.tables.cities') }}@endslot
        @slot('subtitle_route') {{ route('admin.cities.index') }} @endslot
    @endcomponent
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-xxl-10 offset-xxl-1 mt-3">
                        <div class="fw-bold">
                            <h5>{{ __('label.labels.city_info') }}</h5>
                        </div>

                        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" id="form-update">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="cityId" class="form-label">{{ __('label.columns.cities.id') }}</label>
                                <input type="text" class="form-control" id="cityId" value="{{ $city->id }}" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="cityName" class="form-label">{{ __('label.columns.cities.name') }}</label>
                                <input type="text" class="form-control" id="cityName" value="{{ $city->name }}" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="prefectureName" class="form-label">{{ __('label.columns.cities.prefecture') }}</label>
                                <input type="text" class="form-control" id="prefectureName"
                                       value="{{ @$city->prefecture->name }}" disabled readonly>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input cursor-pointer" id="searchExclusion" value="y"
                                       name="search_exclusion_yn"
                                       @if($city->search_exclusion_yn == config('const.boolean.yes')) checked @endif>
                                <label class="form-check-label cursor-pointer" for="searchExclusion">{{ __('label.columns.cities.search_exclusion_yn') }}</label>
                            </div>
                            <div class="mb-3">
                                <label for="cityGroupId" class="form-label">{{ __('label.columns.cities.city_group') }}</label>
                                <select name="city_group_id" class="form-select" id="cityGroupId">
                                    <option value="">--</option>
                                    @foreach($city_groups as $key => $city_group)
                                        <option value="{{ $key }}" @if($city->city_group_id == $key) selected @endif>{{ $city_group }}</option>
                                    @endforeach
                                </select>
                                @error('city_group_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sortOrder" class="form-label">{{ __('label.columns.common.sortno') }}</label>
                                <input type="text" class="form-control" id="sortOrder" value="{{ $city->sortno }}" disabled readonly>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" form="form-update" class="btn btn-primary ms-3">{{ __('label.buttons.save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<input type="hidden" value="{{@$location->id}}" name="location_id">

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">医療機関コード</label>
        <div class="form-control-feedback">
            <input type="text"
                   class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', @$location->code ) }}" name="code" maxlength="7"/>
        </div>
        <span class="text-error" id="code-error">
            @if($errors->has('code')){{ $errors->first('code') }}@endif
        </span>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">契約状況</label>
        <div class="form-control-feedback">
            <div id="contract-number" class="d-flex gap-1 fs-14 cursor-pointer {{old('contract_id',@$location->contract->contract_number)? 'd-block': 'd-none'}}">
                @if($location->contract)
                    <a class="fw-semibold" href="{{route('admin.contracts.edit', $location->contract->id)}}" target="_blank">
                        <span class="">契約番号: {{@$location->contract->contract_number}}</span>
                        <i class="ph-arrow-square-out fw-semibold"></i>
                    </a>
                    <i class="icon-cancel-circle2" id="remove-contract"></i>
                @endif
            </div>
            <input type="hidden" value="{{@$location->contract->id}}" name="contract_id">
            <button type="button"
                    class="btn btn-light btn-sm mo-btn_select_contract_status {{@$location->contract->contract_number? 'd-none': 'd-block'}}"
                    data-bs-toggle="modal"
                    data-bs-target="#selectContractStatus">契約状況を選択
            </button>
        </div>
        <span class="text-error" id="contract_id-error">
            @if($errors->has('contract_id')){{ $errors->first('contract_id') }}@endif
        </span>
    </div>
</div>

<div class="row mb-3 @if(!isset($location->contract)) d-none @endif" id="employer-box">
    <div class="form-group col-lg-6">
    </div>
    <div class="form-group col-lg-6">
        <div class="form-group row" id="employer-box">
            <label class="col-3 fw-semibold">採用担当者</label>
            <div class="col-sm-9">
                <div class="d-flex flex-column align-items-start" id="employee-list">
                    @if(@$location->contract && @$location->contract->employers->count() > 0)
                        @foreach(@$location->contract->employers()->get() as $key => $employer)
                            <div class="form-check mo-form_check mo-checkbox">
                                <input name="employer_id[]" type="checkbox" class="form-check-input cursor-pointer"
                                       value="{{$employer->id}}"]
                                       id="employer_name_{{$key}}"
                                       @if(in_array($employer->id, old('employer_id',@$location->employerLocations()->pluck('employer_id')->toArray()))) checked @endif/>
                                <label for="employer_name_{{$key}}" class="form-check-label cursor-pointer">{{$employer->full_name}}（{{$employer->employerRole->label}}）</label>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">医療機関名</label>
        <div class="form-control-feedback">
            <input type="text" maxlength="255"
                   class="form-control @error('name') is-invalid @enderror"
                   name="name"
                   value="{{ old('name', @$location->name) }}">
            <span class="text-error" id="name-error">
                @if($errors->has('name')){{ $errors->first('name') }}@endif
            </span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">医療機関名（カナ）</label>
        <div class="form-control-feedback">
            <input type="text" maxlength="255"
                   class="form-control @error('name_kana') is-invalid @enderror"
                   name="name_kana"
                   value="{{ old('name_kana', @$location->name_kana) }}">
            <span class="text-error" id="name_kana-error">
                @if($errors->has('name_kana')){{ $errors->first('name_kana') }}@endif
            </span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">施設種別</label>
        <div class="form-control-feedback">
            <div class="d-flex flex-wrap fs-14 gap-2">
                @foreach(config('const.location_types') as $key => $location_type)
                    <div class="form-check">
                        <input name="location_type[]"
                               @if(in_array($key, old('location_type', @$location->location_types ?? @$location->locationLocationTypes->pluck('location_type')->toArray()))) checked
                               @endif value="{{$key}}"
                               id="checkbox{{$key}}"
                               class="location_type form-check-input cursor-pointer"
                               type="checkbox"/>
                        <label class="form-check-label cursor-pointer" for="checkbox{{$key}}">{{$location_type}}</label>
                    </div>
                @endforeach
            </div>
            <span class="text-error" id="location_type-error">
                @if($errors->has('location_type')){{ $errors->first('location_type') }}@endif
            </span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">医療グループ</label>
        <div class="form-control-feedback">
            <select name="location_group_id" class="form-control short-input @error('location_group_id') is-invalid @enderror">
                <option value="">--</option>
                @foreach($location_groups as $location_group)
                    <option @if(old('location_group_id', @$location->location_group_id) == $location_group['id']) selected
                            @endif value="{{$location_group['id']}}">{{$location_group['name']}}</option>
                @endforeach
            </select>
            <span class="text-error" id="location_group_id-error">
                @if($errors->has('location_group_id')){{ $errors->first('location_group_id') }}@endif
            </span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">診療科目</label>
        <div class="form-control-feedback">
            <div class="mo-textarea">
                <textarea maxlength="225" name="medical_department" class="form-control"
                          rows="3">{{old('medical_department', @$location->medical_department)}}</textarea>
            </div>
            <span class="text-error" id="medical_department-error">
                @if($errors->has('medical_department')){{ $errors->first('medical_department') }}@endif
            </span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">郵便番号</label>
        <div class="form-control-feedback d-flex align-items-center">
            <input value="{{old('postal_code', @$location->postal_code)}}" type="text" maxlength="255" name="postal_code"
                   class="form-control @if($errors->has('postal_code')) is-invalid @endif short-input input-post_code_field"
                   placeholder="000-0000"/>
            <a target="_blank" href="https://www.post.japanpost.jp/zipcode/" type="button"
               class="btn btn-light btn-sm btn-search_zip_code">
                郵便番号を検索
            </a>
        </div>
        <span class="text-error" id="postal_code-error">
            @if($errors->has('postal_code')){{ $errors->first('postal_code') }}@endif
        </span>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">都道府県</label>
        <div class="form-control-feedback">
            <select name="prefecture_id"
                    class="js-select-prefecture form-select @if($errors->has('prefecture_id')) is-invalid @endif mo-select mo-select_prefectures">
                <option value>選択してください</option>
                @foreach($prefectures as $key => $prefecture)
                    <option @if(old('prefecture_id', @$location->prefecture_id) == $prefecture->id) selected @endif
                        value="{{$prefecture->id}}">{{$prefecture->name}}</option>
                @endforeach
            </select>
            <span class="text-error" id="prefecture_id-error">
                @if($errors->has('prefecture_id')){{ $errors->first('prefecture_id') }}@endif
            </span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">市区町村</label>
        <div class="form-control-feedback">
            <select name="city_id"
                    class="form-select js-select-city @if($errors->has('city_id')) is-invalid @endif mo-select mo-select_municipalities">
                <option value class="js-static">選択してください</option>
                @foreach($cities as $key => $city)
                    <option @if(old('city_id', @$location->city_id) == $city->id) selected
                            @endif value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
            <span class="text-error" id="city_id-error">
                @if($errors->has('city_id')){{ $errors->first('city_id') }}@endif
            </span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">番地以降</label>
        <div class="form-control-feedback">
            <input value="{{old('address1', @$location->address1)}}" type="text" maxlength="255" name="address1"
                   class="form-control @error('address1') is-invalid @enderror"
            />
        </div>
        <span class="text-error" id="address1-error">
            @if($errors->has('address1')){{ $errors->first('address1') }}@endif
        </span>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">マンション名</label>
        <div class="form-control-feedback">
            <input value="{{old('address2', @$location->address2)}}" type="text" maxlength="255" name="address2"
                   class="form-control @error('address2') is-invalid @enderror"
            />
        </div>
        <span class="text-error" id="address2-error">
            @if($errors->has('address2')){{ $errors->first('address2') }}@endif
        </span>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">座標</label>
        <div class="form-control-feedback">
            <div class="row">
                <div class="col-lg-6">
                    <input value="{{old('lat', @$location->lat)}}" name="lat" type="text" maxlength="255" placeholder="緯度"
                           class="form-control @if($errors->has('lat')) is-invalid @endif mo-input"/>
                    @if($errors->has('lat'))
                        <div class="text-error">{{ $errors->first('lat') }}</div>
                    @endif
                    <div class="form-text">例）35.6871051</div>
                </div>
                <div class="col-lg-6">
                    <input value="{{old('lon', @$location->lon)}}" name="lon" type="text" maxlength="255" placeholder="経度"
                           class="form-control @if($errors->has('lon')) is-invalid @endif mo-input"/>
                    @if($errors->has('lon'))
                        <div class="text-error">{{ $errors->first('lon') }}</div>
                    @endif
                    <div class="form-text">例） 139.7678403</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <span class="text-error" id="lat-error"></span>
                    <span class="text-error" id="lon-error"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">交通アクセス</label>
        <div class="form-control-feedback m">
            <div class="mo-sort">
                <ul id="sortable" class="m-0 p-0">
                    @if(count(old('line_cd', @$location->line_cd)) > 0)
                        @foreach(old('line_cd', @$location->line_cd) as $line_cd)
                            @include("admin.locations.components.location_access")
                        @endforeach
                    @endif
                </ul>
                <span class="text-error" id="line_cd-error">
                    @if($errors->has('line_cd')){{ $errors->first('line_cd') }}@endif
                </span>
                <span class="btn btn-light btn-sm sort-add">追加</span>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">電話番号</label>
        <div class="form-control-feedback">
            <input value="{{old('tel', @$location->tel)}}" name="tel" type="text" maxlength="255"
                   class="form-control @if($errors->has('tel')) is-invalid @endif"/>
        </div>
        <span class="text-error" id="tel-error">@if($errors->has('tel')){{ $errors->first('tel') }}@endif</span>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">ホームページURL</label>
        <div class="form-control-feedback">
            <input value="{{old('url', @$location->url)}}" name="url" type="text" maxlength="255"
                   placeholder="https://www.iryoukikan.or.jp"
                   class="form-control @if($errors->has('url1')) is-invalid @endif"/>
        </div>
        <span class="text-error" id="url-error">@if($errors->has('url')){{ $errors->first('url') }}@endif</span>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">救急対応</label>
        <div class="form-control-feedback">
            <select name="emergency_support_yn" class="form-select mo-select mo-select_emergency">
                <option value="">--</option>
                @foreach(config('const.emergency_support_yn') as $key => $value)
                    <option @if(old('emergency_support_yn', @$location->emergency_support_yn) == $key) selected
                            @endif value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <span class="text-error" id="emergency_support_yn-error">@if($errors->has('emergency_support_yn')){{ $errors->first('emergency_support_yn') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">病棟数</label>
        <div class="form-control-feedback d-flex gap-2 align-items-center">
            <input value="{{old('number_of_beds', @$location->number_of_beds)}}" name="number_of_beds" type="text" maxlength="255"
                   class="form-control @if($errors->has('number_of_beds')) is-invalid @endif mo-input mo-input-md"/>
            <select name="number_of_beds_type" class="form-select mo-select mo-select_number_wards">
                <option value="">--</option>
                @foreach(config('const.number_of_beds_types') as $key => $value)
                    <option @if(old('number_of_beds_type', @$location->number_of_beds_type) == $key) selected
                            @endif value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <span class="text-error" id="number_of_beds-error">@if($errors->has('number_of_beds')){{ $errors->first('number_of_beds') }}@endif</span>
            <span class="text-error" id="number_of_beds_type-error">@if($errors->has('number_of_beds_type')){{ $errors->first('number_of_beds_type') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">透析ベッド数</label>
        <div class="form-control-feedback">
            <input value="{{old('number_of_dialysis_beds', @$location->number_of_dialysis_beds)}}"
                   name="number_of_dialysis_beds"
                   type="int"
                   class="form-control @if($errors->has('number_of_dialysis_beds')) is-invalid @endif"/>
            <span class="text-error" id="number_of_dialysis_beds-error">@if($errors->has('number_of_dialysis_beds')){{ $errors->first('number_of_dialysis_beds') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">開設日</label>
        <div class="form-control-feedback">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="ph-calendar"></i>
                </span>
                <input name="open_date" type="text"
                       class="form-control datepicker-autohide datepicker-input @if($errors->has('open_date')) is-invalid @endif"
                       autocomplete="off"
                       value="{{old('open_date', @$location->open_date)}}"
                       placeholder="{{date('Y/m/d', strtotime(now()))}}"/>
            </div>
            <span class="text-error" id="open_date-error">@if($errors->has('open_date')){{ $errors->first('open_date') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">使用者役職</label>
        <div class="form-control-feedback">
            <input value="{{old('employer_title', @$location->employer_title)}}"
                   name="employer_title"
                   type="text"
                   class="form-control @if($errors->has('employer_title')) is-invalid @endif"/>
            <span class="form-text">労働通知書の使用者情報と同様になります。</span>
            <span class="text-error" id="employer_title-error">@if($errors->has('employer_title')){{ $errors->first('employer_title') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold label_required">使用者氏名</label>
        <div class="form-control-feedback">
            <div id="items-container">
                @if(old('employer_family_names', @$location->employer_names))
                    @foreach(old('employer_family_names', @$location->employer_names) as $index => $item)
                        <div class="form-control-feedback d-flex gap-2 align-items-center mb-2">
                            <div>
                                <input type="text" name="employer_family_names[]" class="form-control @if($errors->has('employer_family_names.' . $index)) is-invalid @endif" placeholder="姓" value="{{ old('employer_family_names.' . $index, $item['family_name']) }}">
                                <span class="text-error" id="employer_family_names-{{$index}}-error">@if($errors->has('employer_family_names.' . $index)){{ $errors->first('employer_family_names.' . $index) }}@endif</span>
                            </div>
                            <div>
                                <input type="text" name="employer_first_names[]" class="form-control @if($errors->has('employer_first_names.' . $index)) is-invalid @endif" placeholder="名" value="{{ old('employer_first_names.' . $index, $item['first_name']) }}">
                                <span class="text-error" id="employer_first_names-{{$index}}-error">@if($errors->has('employer_first_names.' . $index)){{ $errors->first('employer_first_names.' . $index) }}@endif</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-control-feedback d-flex gap-2 align-items-center mb-2">
                        <div>
                            <input type="text" name="employer_family_names[]" class="form-control @if($errors->has('employer_family_names.0')) is-invalid @endif" placeholder="姓">
                            <span class="text-error" id="employer_family_names-0-error">@if($errors->has('employer_family_names.0')){{ $errors->first('employer_family_names.0') }}@endif</span>
                        </div>
                        <div>
                            <input type="text" name="employer_first_names[]" class="form-control @if($errors->has('employer_first_names.0')) is-invalid @endif" placeholder="名">
                            <span class="text-error" id="employer_first_names-0-error">@if($errors->has('employer_first_names.0')){{ $errors->first('employer_first_names.0') }}@endif</span>
                        </div>
                    </div>
                @endif
            </div>

            <button type="button" class="btn btn-light" id="addItem">使用者を追加する</button>

            <textarea maxlength="255" class="form-control mt-2" rows="3"
                      name="work_items_detail">{{ old('work_items_detail', @$spot_post->work_items_detail) }}</textarea>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">理事長名</label>
        <div class="form-control-feedback">
            <input value="{{old('founder_name', @$location->founder_name)}}" name="founder_name" type="text" maxlength="255"
                   class="form-control @if($errors->has('founder_name')) is-invalid @endif"/>
            <span class="text-error" id="founder_name-error">@if($errors->has('founder_name')){{ $errors->first('founder_name') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">院長名</label>
        <div class="form-control-feedback">
            <input value="{{old('manager_name', @$location->manager_name)}}" type="text" maxlength="255" name="manager_name"
                   class="form-control @if($errors->has('manager_name')) is-invalid @endif"/>
            <span class="text-error" id="manager_name-error">@if($errors->has('manager_name')){{ $errors->first('manager_name') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨部署</label>
        <div class="form-control-feedback">
            <input value="{{old('contact_department', @$location->contact_department)}}" type="text" maxlength="255" name="contact_department"
                   class="form-control @if($errors->has('contact_department')) is-invalid @endif"/>
            <span class="text-error" id="contact_department-error">@if($errors->has('contact_department')){{ $errors->first('contact_department') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨役職</label>
        <div class="form-control-feedback">
            <input value="{{old('contact_position', @$location->contact_position)}}" type="text" maxlength="255" name="contact_position"
                   class="form-control @if($errors->has('contact_position')) is-invalid @endif"/>
            <span class="text-error" id="contact_position-error">@if($errors->has('contact_position')){{ $errors->first('contact_position') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨担当者名</label>
        <div class="form-control-feedback d-flex gap-2 align-items-center">
            <input value="{{old('contact_family_name', @$location->contact_family_name)}}" name="contact_family_name" type="text" maxlength="255"
                   class="form-control @if($errors->has('contact_family_name')) is-invalid @endif"/>
            <input value="{{old('contact_first_name', @$location->contact_first_name)}}" name="contact_first_name" type="text" maxlength="255"
                   class="form-control @if($errors->has('contact_first_name')) is-invalid @endif"/>
            <span class="text-error" id="contact_family_name-error">@if($errors->has('contact_family_name')){{ $errors->first('contact_family_name') }}@endif</span>
            <span class="text-error" id="contact_first_name-error">@if($errors->has('contact_first_name')){{ $errors->first('contact_first_name') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨担当者名（カナ）</label>
        <div class="form-control-feedback d-flex gap-2 align-items-center">
            <input value="{{old('contact_family_name_kana', @$location->contact_family_name_kana)}}" name="contact_family_name_kana" type="text" maxlength="255"
                   class="form-control @if($errors->has('contact_family_name_kana')) is-invalid @endif"/>
            <input value="{{old('contact_first_name_kana', @$location->contact_first_name_kana)}}" name="contact_first_name_kana" type="text" maxlength="255"
                   class="form-control @if($errors->has('contact_first_name_kana')) is-invalid @endif"/>
            <span class="text-error" id="contact_family_name_kana-error">@if($errors->has('contact_family_name_kana')){{ $errors->first('contact_family_name_kana') }}@endif</span>
            <span class="text-error" id="contact_first_name_kana-error">@if($errors->has('contact_first_name_kana')){{ $errors->first('contact_first_name_kana') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨電話番号</label>
        <div class="form-control-feedback">
            <input value="{{old('contact_phone', @$location->contact_phone)}}" type="text" maxlength="255" name="contact_phone"
                   class="form-control @if($errors->has('contact_phone')) is-invalid @endif"/>
            <span class="text-error" id="contact_phone-error">@if($errors->has('contact_phone')){{ $errors->first('contact_phone') }}@endif</span>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">お問い合わせ先￨メールアドレス</label>
        <div class="form-control-feedback">
            <input value="{{old('contact_email', @$location->contact_email)}}" type="text" maxlength="255" name="contact_email"
                   class="form-control @if($errors->has('contact_email')) is-invalid @endif"/>
            <span class="text-error" id="contact_email-error">@if($errors->has('contact_email')){{ $errors->first('contact_email') }}@endif</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="form-group col-lg-6">
        <label class="form-label fw-semibold">参照コード</label>
        <div class="form-control-feedback">
            <input value="{{old('reference_code', @$location->reference_code)}}" type="text" maxlength="255" name="reference_code"
                   class="form-control @if($errors->has('reference_code')) is-invalid @endif"/>
            <span class="text-error" id="reference_code-error">@if($errors->has('reference_code')){{ $errors->first('reference_code') }}@endif</span>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    let index = $('#items-container .form-control-feedback').length;

    $('#addItem').click(function () {
      $('#items-container').append(`
        <div class="form-control-feedback d-flex gap-2 align-items-center mb-2">
            <div>
                <input type="text" name="employer_family_names[]" class="form-control" placeholder="姓">
                <span class="text-error" id="employer_family_names-${index}-error"></span>
            </div>
            <div>
                <input type="text" name="employer_first_names[]" class="form-control" placeholder="名">
                <span class="text-error" id="employer_first_names-${index}-error"></span>
            </div>
        </div>
    `);
    });
    $(document).on('click', '.remove-item', function () {
      $(this).parent().remove();
    });
  });
</script>

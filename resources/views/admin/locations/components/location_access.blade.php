<li class="sort-item d-flex mb-2 col-sm-12 ui-sortable-handle location-access-list">
    <div class="item-info d-flex align-items-center">
        <div class="col-12 item-main js-select-station-div">
            <div class="row">
                <div class="col-12 ps-0">
                    <div class="item-header row">
                        <div class=" col-5">路線</div>
                        <div class="col-4">駅名</div>
                        <div class="col-3"></div>
                    </div>
                    <input class="station-cd" type="hidden" name="station_g_cd[{{$loop->index}}]"
                           value="{{@$location->station_g_cd[$loop->index] }}">
                    <div class="item-content row align-items-center">
                        <div class="col-5">
                            <span class="line-name mo-custom_line_station_name">{{@$location->line_name[$loop->index] ?? '駅を選択してください'}}</span><br>
                            <span class="text-error" id="station_g_cd-{{$loop? $loop->index: 0}}-error"></span>
                        </div>
                        <div class="col-4 station-name mo-custom_line_station_name">{{@$location->station_name[$loop->index] ?? '--'}}</div>
                        <div class="col-3">
                            <button
                                data-station="{{@$location->station_g_cd[$loop->index]}}"
                                data-line="{{@$line_cd}}" type="button"
                                data-linename="{{@$location->line_name[$loop->index]}}" type="button"
                                class="btn btn-light btn-sm item-btn js-open-station">
                                駅を選択
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 ps-0">
                    <div class="item-header row mb-2">
                        <div class="col-4 pe-0">移動手段</div>
                        <div class="col-3 pe-0">時間（分）</div>
                        <div class="col-5 pe-0">補足</div>
                    </div>
                    <div class="item-content row">
                        <div class="col-4 d-flex align-items-center pe-0 gap-2">
                            <select name="transportation_type[{{$loop? $loop->index: 0}}]"
                                class="form-select mo-select mo-select_traffic_access"
                                id="transportation_type-{{$loop? $loop->index: 0}}-error-input"
                            >
                                <option value="">--</option>
                                @php
                                    $loop_index = @$loop->index;
                                @endphp
                                @foreach(config('const.transportation_types') as $key=>$value)
                                    <option
                                        @if(@$location->transportation_type[@$loop_index]==$key) selected
                                        @endif  value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <span>で</span>
                        </div>
                        <div class="col-3 d-flex align-items-center pe-0 gap-2">
                            <input
                                value="{{@$location->total_minutes[$loop->index]}}"
                                name="total_minutes[{{$loop? $loop->index: 0}}]" type="text"
                                class="form-control mo-input mo-input_traffic_access_time"
                                id ="total_minutes-{{$loop? $loop->index: 0}}-error-input"/>
                            <span>分</span>
                        </div>
                        <div class="col-5 pe-0">
                            <input type="text" name="access_text[{{$loop? $loop->index: 0}}]"
                                   value="{{@$location->access_text[$loop->index]}}"
                                   class="form-control mo-input mo-input_traffic_access_supplement"/>
                        </div>
                    </div>
                    <div class="row">
                        <span class="text-error" id="transportation_type-{{$loop? $loop->index: 0}}-error"></span>
                        <span class="text-error" id="total_minutes-{{$loop? $loop->index: 0}}-error"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="item-close d-flex m-auto ms-2 cursor-pointer">
        <i class="ph-x-circle ms-1"></i>
    </div>
</li>

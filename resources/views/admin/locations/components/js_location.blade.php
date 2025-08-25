<script>
    $(document).ready(function () {
        // drab drop
        $("#sortable").sortable();

        // remove DOM drab drop
        $(document).on('click', '.item-close', function () {
            const parent = $(this).parent();
            parent.remove();
        });
        // append DOM drab drop
        $(".sort-add").on("click", function (e) {
            var countChild = $("#sortable").children("li").length;
            const content = `
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
                                    <input class="station-cd" type="hidden" name="station_g_cd[${countChild}]"
                                           value="">
                                    <div class="item-content row align-items-center">
                                        <div class="col-5">
                                            <span class="line-name mo-custom_line_station_name">駅を選択してください</span><br>
                                            <span class="text-error" id="station_g_cd-${countChild}-error"></span>
                                        </div>
                                        <div class="col-4 station-name mo-custom_line_station_name">--</div>
                                        <div class="col-3">
                                            <button
                                                data-station=""
                                                data-line="" type="button"
                                                data-linename="" type="button"
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
                                            <select name="transportation_type[${countChild}]"
                                                    class="form-select mo-select mo-select_traffic_access"
                                                    id="transportation_type-${countChild}-error-input">
                                                <option value="">--</option>
                                                @foreach(config('const.transportation_types') as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <span>で</span>
                                        </div>
                                        <div class="col-3 d-flex align-items-center pe-0 gap-2">
                                            <input
                                                value=""
                                                name="total_minutes[${countChild}]" type="text"
                                                class="form-control mo-input mo-input_traffic_access_time"
                                                id ="total_minutes-${countChild}-error-input"/>
                                            <span>分</span>
                                        </div>
                                        <div class="col-5 pe-0">
                                            <input type="text" name="access_text[${countChild}]"
                                                   value=""
                                                   class="form-control mo-input mo-input_traffic_access_supplement"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span class="text-error" id="transportation_type-${countChild}-error"></span>
                                        <span class="text-error" id="total_minutes-${countChild}-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-close d-flex m-auto ms-2 cursor-pointer">
                        <i class="ph-x-circle ms-1"></i>
                    </div>
                </li>
            `;
            $("#sortable").append(content);
        });

        // count character textarea
        $("textarea").on("input keyup", function () {
            var characters = $(this).val().length;
            $(this).parent().find(".mo-textarea_char_count").text(characters);
        });

        //logic select contract status
        //default
        @if(old('contract_number', $location->contract_number))
        $('.mo-contract_status_add').hide()
        $('.mo-btn_close_contract').show()
        $('.mo-contract_status_view').show()
        @else
        $('.mo-btn_close_contract').hide()
        $('.mo-contract_status_add').show();
        @endif
        $('.mo-contract_status_view').hide();
        $('.mo-btn_close_contract').on('click', function () {
            $(this).hide();
            $('#contract_number').text('');
            $('#contract_number_input').val('');
            $('.mo-contract_status_add').show();
            $('.mo-contract_status_view').hide();
            $('.employers').empty();
            $('.employers').append('<p class="mb-0 fs-14 contract-name">契約状況を選択してください。</p>')
        })
    });
</script>

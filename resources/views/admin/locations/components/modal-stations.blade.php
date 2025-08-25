<div class="modal fade mo-modal" id="select-stations" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="modal-title">駅を選択する</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <div class="street-name mb-3 col-5">
                            <div class="row">
                                <div class="col-3">
                                    <span>路線名</span>
                                </div>
                                <div class="col-9">
                                <select id="train-lines-modal-select" class="form-select mo-select line-select">
                                    <option class="js-static">--</option>
                                    @foreach($train_lines as $train_line)
                                        <option value="{{$train_line['line_cd']}}">{{$train_line['line_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>

                        </div>
                        <div class="station-name col-5">
                            <div class="row">
                                <div class="col-2">
                                    <span>駅名</span>
                                </div>
                                <div class="col-9">
                                <div class="row mb-3">
                                    <div class="col-6 w-100">
                                        <select id="station-modal-select" class="form-select mo-select station-select">
                                            <option class="js-static">--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <span id="train-line-station" class="description"></span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button id="js-submit-station" type="button" class="btn btn-light mo-btn_modal me-3"
                        data-bs-dismiss="modal">
                    選択する
                </button>
            </div>
        </div>
    </div>
</div>

{{--<link href="{{ asset('assets/admin/select2.min.css') }}" rel="stylesheet" />--}}
<script src="{{ asset('assets/admin/js/vendor/forms/selects/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var selectIds = ['#train-lines-modal-select', '#station-modal-select'];

        selectIds.forEach(function(id) {
            $(id).select2({
                dropdownParent: $('#select-stations')
            });
        });
    });
</script>

<div class="modal fade mo-modal" id="selectContractStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title">契約状況を選択</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="col-md-12 px-0 mt-3">
                <div class="mo-btn_redirect px-4">
                    <a target="_blank" href="{{route('admin.contracts.create')}}" type="button" class="btn btn-light btn-sm">
                        契約状況を新規追加 <i class="ph-arrow-square-out ms-1 pb-1"></i>
                    </a>
                </div>
            </div>
            <div class="modal-body px-4">
                <div class="contract-status">
                    <div class="card">
                        <table id="contract-table" class="table datatable-selection-single mo-table_responsive">
                            <thead>
                            <tr>
                                <th class="text-start th-width-5">#契約番号</th>
                                <th class="text-start th-width-10">契約ステータス</th>
                                <th class="text-start th-width-5">求人</th>
                                <th class="text-start th-width-5">斡旋</th>
                                <th class="text-start th-width-5">相対</th>
                                <th class="text-start th-width-10">契約先名</th>
                                <th class="text-start th-width-15">医療機関</th>
                                <th class="text-start th-width-10">採用担当者</th>
                                <th class="text-start th-width-10">請求先</th>
                                <th class="text-start th-width-10"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contracts as $contract)
                                <tr class="align-middle">
                                    <td class="text-start">
                                        <a class="fw-semibold" target="_blank"
                                           href="{{route('admin.contracts.edit', $contract->id)}}">
                                            {{ $contract->contract_number }}
                                        </a>
                                    </td>
                                    <td class="text-start">
                                        <button type="button" class="btn btn-sm btn-{{config('mo.contract_statuses')[$contract->contract_status]}} rounded-pill cursor-default">
                                            <span class="contract-status fs-xs contract_status_{{$contract->contract_status}}">{{$contract->contract_status_label}}</span>
                                        </button>
                                    </td>
                                    <td class="text-start">
                                        @if($contract->post_input_yn == 'y')
                                            <i class="icon-checkmark-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if($contract->referral_yn == 'y')
                                            <i class="icon-checkmark-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if($contract->direct_yn == 'y')
                                            <i class="icon-checkmark-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td class="text-start">{{ $contract->name }}</td>
                                    <td class="text-start">
                                        @foreach($contract->locations as $location)
                                            <a class="fw-semibold" target="_blank" href="{{ route("admin.locations.edit", $location->id) }}">{{$location->name}}</a>
                                        @endforeach
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex flex-column">
                                            @foreach($contract->employers as $employer)
                                                <a class="fw-semibold" target="_blank" href="{{ route("admin.employers.edit", $employer->id) }}">{{$employer->full_name}}</a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <span>{{$contract->billing_name}}</span><br>
                                        <span class="mo-text_span_convert">{{$contract->billing_department}}</span><br>
                                        <span class="mo-text_span_convert">{{$contract->billing_full_name}}</span>
                                    </td>
                                    <td class="text-start">
                                        <div class="list-icons text-end">
                                            <button
                                                data-selected="{{json_encode (['id' => $contract->id, 'code'=>$contract->contract_number, 'url' => route('admin.contracts.edit', $contract->id), 'employers' => $contract->employers->pluck('full_name_role', 'id')->toArray()])}}"
                                                class="js-add-contract btn btn-light btn-sm mo-btn-custom">選択
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        let table = $("#contract-table").DataTable({
          language: @json(trans('datatable')),
          dom: '<"datatable-header"lf><"datatable-scroll"t><"datatable-footer"ip>',
          order: [[0, 'desc']],
        });

        let cells = table.cells().nodes();
        $(cells).find(".js-add-contract").on('click', function (e) {
            e.preventDefault();
            const obj_contract = $(this).data('selected');
            if ($("input[name='contract_id']").val() == obj_contract.id) {
                $('#selectContractStatus').modal('hide');
                return;
            }
            $(".mo-btn_select_contract_status").removeClass("d-block");
            $(".mo-btn_select_contract_status").addClass("d-none");
            $('#contract-number').removeClass("d-none");
            $('#contract-number').removeClass("d-block");
            $('#contract-number').html(`
                <a class="fw-semibold" href="${obj_contract.url}" target="_blank">
                    <span class="">契約番号: ${obj_contract.code}</span>
                    <i class="ph-arrow-square-out fw-semibold"></i>
                </a>
               <i class="icon-cancel-circle2" id="remove-contract"></i>
            `);
            $("input[name='contract_id']").val(obj_contract.id);
            $("#employee-list").empty();
            Object.keys(obj_contract.employers).forEach(function (key, index) {
                $("#employer-box").removeClass('d-none');
                $("#employee-list").addClass('flex-column align-items-start')
                $("#employee-list").append(`
                    <div class="form-check mo-form_check mo-checkbox">
                        <input id="employer_name_str" name="employer_id[]" type="checkbox" class="form-check-input mo-check_input cursor-pointer" value="${key}"/>
                        <label class="form-check-label">${obj_contract.employers[key]}</label>
                    </div>
                `)
            });
            $('#selectContractStatus').modal('hide');
        })
        $(document).on('click', '#remove-contract', function () {
            $("#contract-number").removeClass("d-block").addClass("d-none");
            $(".mo-btn_select_contract_status").removeClass("d-none").addClass("d-block");
            $("input[name='contract_id']").val("");
            $("#employee-list").empty();
            $("#employer-box").addClass('d-none');
        })
    });
</script>

<div class="mo-activity_log mo-tab_content mo-information_wrap mo-memo_log">
    <form id="form-admin_memos" method="POST" data-url="{{ route('admin.admin_memos.store') }}"
          data-record_model="{{ @$record_model }}" data-record_id="{{ @$record_id }}">
        @csrf
        <h5 class="fw-bold">管理メモ</h5>
        <div id="list-memo" class="mo-form_scroll p-3">
            @if(isset($admin_memos) && count($admin_memos) > 0)
                @foreach($admin_memos as $key => $admin_memo)
                    <div class="d-flex align-items-start mb-3" id="memo-{{ $admin_memo->id }}">
                        <a href="#" class="me-3">
                            {!! $admin_memo->admin->renderAvatar() !!}
                        </a>
                        <div class="flex-fill">
                            <span>{!! $admin_memo->description !!}</span>
                            <div class="fs-sm text-muted mt-1">
                                <span>{{ \Carbon\Carbon::parse($admin_memo->created_at)->diffForHumans() . '　' . $admin_memo->full_name_admin }}</span>
                                @if($admin_memo->admin_id == \Illuminate\Support\Facades\Auth::guard('admin')->user()->id)
                                    <a class="cursor-pointer link-teal float-end me-3 mo-remove_icon_card_admin_note" data-memo_id="{{ $admin_memo->id }}"
                                       data-url="{{ route('admin.admin_memos.destroy', $admin_memo->id) }}">削除</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="mo-textarea mt-3 mb-3">
            <textarea class="form-control" id="memo-description" placeholder="コメントを追加" name="description"></textarea>
        </div>
        <button type="button" class="btn btn-light btn-sm mo-btn_add_memo" id="btn-add_memo">送信</button>
    </form>
</div>
@include('admin.components.js_memo')

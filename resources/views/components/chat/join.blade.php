<div class="overlay mt-3 mb-2">
    <i class="ph-eye"></i> <span>このメッセージはあなたにのみ表示されています</span>
    <div class="bg-secondary bg-opacity-10 border-white border-opacity-20 rounded p-3 text-center mt-2">
        <p class="fw-bold">メッセージの送付</p>
        <p class="fw-bold">メッセージを送付するには、以下のボタンをクリックしたてください。</p>
        <button @click="joinChat" class="btn btn-white" :disabled="joinLoading">
            <span x-show="!joinLoading">メッセージに参加する</span>
            <span x-show="joinLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </div>
</div>
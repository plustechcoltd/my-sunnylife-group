<div x-data="chat_input" class="d-flex align-items-center">
    {{--    <a href="#" class="btn btn-light btn-icon border-transparent rounded-pill btn-sm me-1" data-bs-popup="tooltip"--}}
    {{--       aria-label="Formatting" data-bs-original-title="Formatting">--}}
    {{--        <i class="ph-text-aa"></i>--}}
    {{--    </a>--}}
    {{--    <a href="#" class="btn btn-light btn-icon border-transparent rounded-pill btn-sm me-1" data-bs-popup="tooltip"--}}
    {{--       aria-label="Emoji" data-bs-original-title="Emoji">--}}
    {{--        <i class="ph-smiley"></i>--}}
    {{--    </a>--}}
    <a href="#" class="btn btn-light btn-icon border-transparent rounded-pill btn-sm me-1 float-start"
       data-bs-popup="tooltip" aria-label="Send file" data-bs-original-title="Send file"
       x-on:click="$refs.fileInput.click()">
        <i class="ph-paperclip"></i>
    </a>
    <input type="file" x-ref="fileInput" class="d-none" id="fileInput" @change="uploadFile">

    <textarea
        x-model="message"
        x-on:keyup="onInputChange"
        x-ref="chatInput"
        x-on:input="adjustHeight"
        @keydown.enter.prevent="debounceSend"
        @keydown.ctrl.enter="onAddLine"
        @keydown.shift.enter="onAddLine"
        class="chat-input flex-grow-1 form-control form-control-content"
        rows="1">
    </textarea>

    <template x-if="filePreview">
        <div class="file-preview">
            <template x-if="selectedFile && selectedFile.type.startsWith('image/')">
                <img :src="filePreview" alt="File Preview" class="img-thumbnail mw-300 mb-2">
            </template>
            <template x-if="selectedFile && !selectedFile.type.startsWith('image/')">
                <p class="text-muted mb-2">No preview available - <span x-text="selectedFile.name"></span></p>
            </template>
            <button type="button" class="btn btn-danger btn-sm" x-on:click="removeFile">Remove</button>
        </div>
    </template>

    <button type="button" class="btn btn-primary ms-1 h-40px" x-on:click="send">
        <i class="ph-paper-plane-tilt"></i>
    </button>
</div>

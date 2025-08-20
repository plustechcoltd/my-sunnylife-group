<label class="form-label">User ID</label>
<select class="form-select select-user select_multiple" multiple="multiple" name="user_id[]"
         data-placeholder="Please Select">
    <option></option>
    @foreach($listUser as $id => $fullName)
        <option value="{{ $id }}" @selected(in_array($id, $selected))>
            ID: {{ $id }} {{ $fullName }}
        </option>
    @endforeach
</select>

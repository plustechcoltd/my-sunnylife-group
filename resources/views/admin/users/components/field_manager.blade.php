<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="mb-3">
            <div class="form-group mb-3">
                <!--  select user  -->
                <x-users.select_user :listUser="$listUser" :selected="$selectedUser ?? []"/>
                @if($errors->has('user_id'))
                    <div class="validation-invalid-label">{{$errors->first('user_id')}}</div>
                @endif
            </div>
        </div>
    </div>
</div>

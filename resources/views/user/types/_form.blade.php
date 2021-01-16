<form>
    @csrf
    <h6 class="text-muted"> მომხმარებლის სტატუსი:
       <b class="" id="user-status-label" > </b>
    </h6>

    <div class="text-left float-left">
        <label class="switch">
            <input type="checkbox"
                   id="user-status"
                   class="success" />
            <span class="slider round"></span>
        </label>
    </div>

    <br />

    <div class="mt-5" style="clear:both">
        <h6 class="text-muted"> მომხმარებლის ტიპი:
            <b class="" id="user-type-label" > </b>
        </h6>

        <label>
            <select class="form-control" id="user-type" >
                <option value="{{ \App\User::TYPE_STANDARD }}"> სტანდარტული </option>
                <option value="{{ \App\User::TYPE_PREMIUM }}"> პრემიუმი </option>
                <option value="{{ \App\User::TYPE_VIP }}"> VIP </option>
            </select>
        </label>
    </div>


</form>

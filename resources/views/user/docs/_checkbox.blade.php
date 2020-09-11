








<div class="card-body ml-2 pl-1">
    @foreach($q->rels as $ind => $rel)
    <label class="ns-container mt-3" style='font-size:.95em; color:rgba(0,0,0,.8);'>{{$rel->value}}
        <input type="checkbox"
               name="{{$q->name}}[]"
               value="{{ $rel->id }}"
               @if(is_array(old($q->name)) && in_array($rel->id, old($q->name))) checked @endif
        >
        <span class="chbox-checkmark"></span>
        <span class='hover-chbox'></span>

        <!-- <span class='chbox-checkmark-sm'></span>
        <span class='hover-chbox-small'></span> -->
   </label>
    @endforeach
</div>

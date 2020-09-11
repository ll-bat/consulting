







<div class='card-body ml-2 pl-1'>
    <div class="form-group" style='max-width:40%;'>
         <label for="sel1">Select list:</label>
         <select class="form-control" id="sel1" name="{{$q->name}}" @if($q->required) required @endif>
             <option class="p-5" selected disabled>choose one</option>
            @foreach($q->rels as $ind => $rel)
                <option class='p-5'
                        value="{{$rel->id}}"
                        @if (old($q->name) == $rel->id) selected @endif
                >{{$rel->value}}</option>
            @endforeach
         </select>
    </div>
</div>

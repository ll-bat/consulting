







<div class='card-body ns-input-container mt-2'>
  <textarea type="text"
            rows='1'
            class="form-control docs-input border-0 ns-textarea ns-font-family border-bottom bg-white autoresize"
            name ="{{$q->name}}"
            placeholder='Your answer here'
            oninput="$(window).trigger('autoresize');"
            >{{old($q->name)}}</textarea>
  <div class="ns-underline"></div>
</div>

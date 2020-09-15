











<div class="media ns-font-family">
    <img src="{{auth()->user()->pathAvatar()}}"  class="mr-3 mt-3 rounded-circle shadow" style="width:40px;height:40px" />
    <div class="media-body">
        <h6>@ <span class="text-info">Author ..</span></h6>

        <textarea class="form-control focus-bottom postComment ns-font-family mb-3"
                  placeholder="Leave your comment here .."
                  style="font-size:14px"
                  rows="2"
        ></textarea>
        <button class="btn btn-info rounded ml-4 mr-3 mt-0 mb-5  pl-3 pr-3 py-2 grey grey-h float-right"
           onclick = "postComment({{$index}}, {{$blog->id}}, 'comments-count{{$index}}')"
        >Post</button>
        <div class="message">
            <p class="error-message red"></p>
        </div>
    </div>
</div>

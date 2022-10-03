<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



function showComments(k){

    let c = $$('comments')[k].style.display

    if (c === "")
    {
        $$('comments')[k].style.display  = "none"
    }
    else
        $$('comments')[k].style.display = ""
}

function postComment(k,i, j) {
    $.ajax({
        url: '/comment/' + i,
        type: 'post',
        data:
            '_token={{csrf_token()}}',
        data: {
            body: $$('postComment')[k].value
        },
        success: function (res) {
            fset(res, j)
        },
        error: function (request, status, error) {
            set(request.responseText);
        }
    });

        $$('error-message')[k].innerHTML = ''
        renderComment($$('postComment')[k].value, k)
        $$('postComment')[k].value = ''


    function set(res) {
        $$('error-message')[k].innerHTML = '{{ __("გთხოვთ შეიყვანოთ ტექსტი") }}'
    }

    function fset(res) {
        let result = 
        `
           <button class="border-0 grey grey-h px-3 py-2 rounded-pill text-black d-none d-md-block"
                   onclick="deleteComment('../comment/${res}/delete', this)"
                   style=""
           >
            <i class='fa fa-trash text-danger' style='font-size:1rem;'></i>
           </button>

           <button class="btn btn-default grey grey-h radius-40 d-block d-md-none"
                   onclick="deleteComment('../comment/${res}/delete', this)"
                   style="font-size:.8em;"
           >remove</button>
        
        `

        $1('render-result').innerHTML = result 
        $1('render-result').id = ''

        // $1(j).innerHTML = parseInt($1(j).innerHTML) + 1
    }
}

function encodeHTML(s) {
       return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
}

function renderComment(body, i) {
    if (body == '') return
    body = encodeHTML(body)
    
    let result = `
                   <div class="media p-3 mb-4 ml-3 ns-font-family hoverable" style="width: 100%; ">
                      <img src="{{getAvatar()}}" class="mr-3 mt-3 rounded-circle comment-image" style="width:50px;height:50px">
                      <div class="media-body" style="padding-bottom:-1px;">
                            <div class='row'>
                                <div class='col'>
                                     <h6>@ <b class="text-info">{{auth()->user()->username ?? false}}</b><span class='text-muted'> says.. </span>
                                     </h6>
                                </div>
                                <div class='col d-none d-md-block'>
                                      <small class="float-right">
                                          <i><span class="font-weight-bolder">Posted on </span>
                                              Today
                                          </i>
                                      </small>
                                </div>
                            </div>
                                 
                              <p class="mycolor font-weight-bold"
                                 style="font-size:.9em;
                                 font-family: 'Comic Sans MS';
                                 max-width: 500px;
                                 word-wrap: break-word;
                                 line-height: 2em;">${body}...
                              </p>

                              <div class="" style="margin-top:-10px;">
                                   <div class="float-right text-secondary">
                                       <div id="render-result">

                                       </div>
                                   </div>
                              </div>
                         </div>
                     </div> `
    $$("all-comments")[i].innerHTML += result
    // console.log($$('all-comments')[i])
}

function toggleCommentLike(url, obj){
    if ($(obj).children().first().hasClass('ns-red'))
         $(obj).children().first().removeClass('ns-red').addClass('ns-lightgrey')
   else 
        $(obj).children().first().removeClass('ns-lightgrey').addClass('ns-red')
           
    axios['get'](url)
}

function deleteComment(url,obj){
    $(obj).parent().parent().parent().parent().parent().remove()
    axios['delete'](url)
}


</script>
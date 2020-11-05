





<div class="media p-3 mb-4 ml-3 ns-font-family hoverable" style="width: 100%; ">

    <img src="{{$comment->user->pathAvatar()}}" alt="Author" class="mr-3 mt-3 rounded-circle comment-image" style="width:50px; height:50px;">
    <div class="media-body" style="padding-bottom:-1px;">

        <div class='row'>
            <div class='col'>
                 <h6>@ <b class="text-info">{{$comment->user->username}}</b><span class="text-muted"> said.. </span></h6>
            </div>
            <div class='col d-none d-md-block'>
                <small class="float-right">
                        <i><span class="font-weight-bolder">Posted on </span>
                            {{$comment->postDate()}}
                        </i>
                </small>
           </div>
        </div>

        <p class="mycolor font-weight-bold"
           style="font-size:.9em;
           font-family: 'Comic Sans MS';
           max-width: 500px;
           word-wrap: break-word;
           line-height: 2em;">{{$comment->body}}...
        </p>

        <div class="" style="margin-top:-10px;">
           @can('update-best-comment', $blog)
                   <button class="pointer border-0 bg-transparent"  onclick="toggleCommentLike('/bestcomment/{{$comment->id}}',this)" style=''>
                       <i class="fa fa-heart @if ($comment->isLiked()) ns-red @else ns-lightgrey @endif"></i>
                    <span class=""></span>

                    </button>
           @endcan
           @guest
             @if ($comment->isLiked())
                  <i class="fa fa-heart ml-2 red"></i>
             @endif
           @endguest
           @can('edit-staff', $comment)
               <div class="float-right text-secondary">
                   <div>
                       <button class="border-0 grey grey-h px-3 py-2 rounded-pill text-black d-none d-md-block"
                               onclick="deleteComment('../comment/{{$comment->id}}/delete', this)"
                               style=""
                       >
                        <i class='fa fa-trash text-danger' style='font-size:1rem;'></i>
                       </button>

                       <button class="btn btn-default grey grey-h radius-40 d-block d-md-none"
                               onclick="deleteComment('../comment/{{$comment->id}}/delete', this)"
                               style="font-size:.8em;"
                       >remove</button>
                    </div>
               </div>
           @endcan
        </div>

    </div>
</div>

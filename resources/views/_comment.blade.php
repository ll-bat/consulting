





{{--//border-left bg-grey--}}
<div class="media p-3 mb-4 ml-3 ns-font-family hoverable" style="width: 100%; ">

    <img src="{{$comment->user->pathAvatar()}}" alt="Author" class="mr-3 mt-3 rounded-circle comment-image" style="width:50px; height:50px;">
    <div class="media-body" style="padding-bottom:-1px;">

        <h6>@ <b class="text-info">{{$comment->user->username}}</b><span class="text-muted"> said.. </span>
            <small class="float-right">
                <i><span class="font-weight-bolder">Posted on </span>
                    {{$comment->postDate()}}
                </i>
            </small>
        </h6>

        <p class="mycolor font-weight-bold"
           style="font-size:.9em;
           font-family: 'Comic Sans MS';
           max-width: 500px;
           word-wrap: break-word;
           line-height: 2em;">{{$comment->body}}...
        </p>

        <div class="" style="margin-top:-10px;">
           @can('update-best-comment', $blog)
                   <a href="/bestcomment/{{$comment->id}}" class="">
                       <i class="fa fa-heart  <?php if ($comment->isLiked()) echo 'red'; else echo 'lightgrey' ?>"></i>
                       <span class=""></span>
                   </a>
                   <a href="" class="pl-2 mytest" style="color:grey;">
                       <i class="fa fa-comment lightgrey"></i>
                       <span class="pl-1 "></span>
                   </a>
           @endcan
           @guest
             @if ($comment->isLiked())
                  <i class="fa fa-heart ml-2 red"></i>
             @endif
           @endguest
           @can('edit-staff', $comment)
               <div class="float-right text-secondary">
                   <form method="post" action="../comment/{{$comment->id}}/delete">
                       @csrf
                       @method('delete')
                       <button class="btn btn-default grey grey-h radius-40"
                               style="font-size:.8em;"
                       >remove</button>
                   </form>
               </div>
           @endcan
        </div>

    </div>
</div>

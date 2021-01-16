@extends('layouts/zim')






@section('header')
   <style>
       .mydocs-border{
           border-bottom: .1rem solid lightseagreen;
           width:0;
           transition: all .2s ease-in;
       }
       .mydocs-item:hover .mydocs-border{
           width:100%;
       }
       .mydocs-item:hover .mydocs-text {
           text-shadow: .4rem .4rem .4rem lightgrey;
       }

       .hoverable {
           border: 2px solid transparent;
           border-radius:10px;
           transition:all .4s ease-out;
       }

       .hoverable:hover {
           border: 2px solid lightgrey;
       }

       .link:active .hoverable {
           border: 2px solid grey;
           background-color:grey;
       }
   </style>
@endsection
@section('content')


    <div class="container-fluid">
        @foreach($docs as $index=>$doc)
            <div class="card shadow-none">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-12">
                            <a href="doc/{{$doc->id}}" style="text-decoration: none !important;">
                                <div class="mydocs-item pointer d-flex">
                                    <div>
                                        <img src="/icons/document2.png" style="width:3rem;"/>
                                    </div>
                                    <div class="mt-2">
                                        <span class="pl-2 mydocs-text text-primary font-weight-bolder" style=""> ჩემი დოკუმენტი {{ $index + 1 }}</span>
                                        <div class="mydocs-border mt-2 ml-2"></div>
                                    </div>
                                </div>
                            </a>

                            <div class='text-muted text-sm mt-4 ml-2'>
                                <b> Created At: </b> {{ $doc->dateCreated() }}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-10">
                            <div class="d-flex mt-2 mt-sm-0">
                                <div class="mr-1">
                                    <button class="btn btn-outline-success rounded-pill text-sm border-0"
                                            onclick='showDownloadModal("download-modal{{$doc->id}}")'  >
                                     გადმოწერა
                                    </button>
                                </div>
                                <div class="">
                                    <button class="btn btn-outline-danger rounded-pill text-sm border-0"
                                            onclick="if(confirm('ნამდვილად გსურთ ამ დოკუმენტის წაშლა ?')) $1('doc-delete{{$index}}').submit()">
                                        წაშლა
                                    </button>

                                    <form method="post" action="doc/{{$doc->id}}/delete"  class="d-none" id="doc-delete{{$index}}">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </div>

                                @include('user._downloadModal', ['id' => $doc->id, 'buttonId' => $doc->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if ($docs->count() == 0)

            <div class = 'alert aler-info text-white' style='background-color:rgba(0,0,200, .5)'>
                <p> თქვენ არ გაქვთ დოკუმენტები. შეავსეთ
                    <a href='questions' class='text-white font-weight-bolder'>  კითქვარი  </a>
                </p>
            </div>
        @endif
    </div>
@endsection

<script>
     function showDownloadModal(id){
            $1(id).click()
     }

     function downloadFile(id){
         tout(() => {
            $1(`close-modal-${id}`).click()
         }, 300)
     }
</script>

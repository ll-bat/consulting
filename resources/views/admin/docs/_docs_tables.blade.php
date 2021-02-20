

<ul class="list-group text-left mt-5 mb-4" style="border-radius:5px;">
    <li class="list-group-item font-weight-bold py-3 pointer"
        onclick="toggleCollapseHandler(this, 'all-in-controls-panel', '{{$color}}')"
        style="background-color: white;border: 1px solid {{$color}};color: {{$color}};">
        <i class='fa fa-plus float-left'></i>
        <span class="pl-4"> ყველა შემავალი {{$typeName}} </span>
    </li>
    @foreach($has as $ind => $d)
        <li class="list-group-item all-in-controls-panel d-none pl-4"
            style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);
                border-left: 1px solid rgba(0,0,0,0.09);
                border-right: 1px solid rgba(0,0,0,.09);
            @if ($ind == count($has)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif
                ">
            <div class="row">
                <div class="col-md-9 col-lg-9 col-xl-10 col-12">
                    <a href='../../{{$type}}/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'>
                        <b>{{$ind + 1}}.</b> {{$d->name}} </a>
                </div>
                <div class="col-md-3 col-lg-3 col-xl-2 col-2 this-div">
                    <a href='edit/{{$d->id}}/detach'
                       class='text-sm capitalize px-md-3 px-0 py-1'
                       style='font-size:.8em;color:indianred '> ამოშლა </a>
                </div>
            </div>
        </li>
    @endforeach
    @if (count($has) == 0)
        <li class="list-group-item all-in-controls-panel d-none pl-4">
            მონაცემები არ არის
        </li>
    @endif
</ul>


<ul class="list-group text-left mt-0 mb-4" style="border-radius:5px;">
    <li class="list-group-item font-weight-bold py-3 pointer"
        onclick="toggleCollapseHandler(this, 'controls-panel', '{{$delcolor}}')"
        style="border: 1px solid {{$delcolor}}; color: {{$delcolor}};">
        <i class='fa fa-plus float-left'></i>
        <span class="pl-4"> ყველა სხვა {{$typeName}} </span>
    </li>
    @foreach($nhas as $ind => $d)
        <li class="list-group-item pl-4 controls-panel d-none"
            style="border:none;border-bottom: 1px solid rgba(0,0,0,.055);
                border-left: 1px solid rgba(0,0,0,0.09);
                border-right: 1px solid rgba(0,0,0,.09);
            @if ($ind == count($nhas)-1) border-bottom: 1px solid rgba(0,0,0,0.1); @endif
                ">
            <div class="row">
                <div class="col-md-10 col-12">
                    <a href='../../{{$type}}/{{$d->id}}/edit' class='mt-1 pb-2 pl-2 text-muted'>
                        <b>{{$ind + 1}}.</b> {{$d->name}} </a>
                </div>
                <div class="col-md-2 col-2 text-md-center text-left this-div">
                    <a href='edit/{{$d->id}}/attach'
                       class='text-sm capitalize px-md-3 px-0 py-1'
                       style='font-size:.8em;color:{{$color}} '> დამატება </a>
                </div>
            </div>
        </li>
    @endforeach
    @if (count($nhas) == 0)
        <li class="list-group-item controls-panel d-none pl-4">
            მონაცემები არ არის
        </li>
    @endif
</ul>


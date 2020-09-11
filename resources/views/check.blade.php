@extends('layouts.app')





@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10 col-10" style="padding-top:6rem;padding-bottom:10rem;">
            <a href="/login" 
                   class="btn btn-outline-danger p-2 radius-40" 
                   style="width:100%; font-size:1.2em;font-family: 'Yu Gothic'" > Login </a>
            <a href="/register" 
               class="btn btn-outline-primary mt-3 p-2 radius-40" style="width:100%; font-size: 1.2em;font-family: 'Yu Gothic'"> Register</a>
         </div>
    </div>
</div>
@endsection

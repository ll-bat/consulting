<?php


function getUrl(){
    return  \Illuminate\Support\Facades\URL::full();
}
function current_user(){
    return auth()->user();
}

function testBack(){
    return asset('storage/backgrounds/background.png');
}

function getAvatar(){
    if (auth()->user()) return current_user()->pathAvatar();
    return asset('storage/avatars/avatar.png');
}

function getTestFolder(){
    return asset('/storage/icons/folder1.png');
}

function userRoutes()
{
    // ['route' => '', 'icon' => 'nc-icon nc-diamond', 'name' => 'Skills'],
    //     ['route' => '', 'icon' => 'nc-icon nc-pin-3', 'name' => 'Location'],

    return [
        ['route' => 'user.home', 'icon' => 'nc-icon nc-bank', 'name' => 'მთავარი'],
        ['route' => 'user.profile', 'icon' => 'nc-icon nc-single-02', 'name' => 'პროფილი'],
        ['route' => 'user.mydocs', 'icon' => 'nc-icon nc-single-copy-04', 'name' => 'ჩემი დოკუმენტ.'],
        ['route' => 'user.questions', 'icon' => 'nc-icon nc-tap-01', 'name' => 'კითხვარი']

    ];
}

function adminRoutes()
{
    return [
        ['route' => 'admin.docs', 'icon' => 'nc-icon nc-paper', 'name' => 'დოკუმენტები'],
        ['route' => 'admin.blog', 'icon' => 'nc-icon nc-tag-content', 'name' => 'ბლოგები'],
        ['route' => 'admin.customize', 'icon' => 'nc-icon nc-ruler-pencil', 'name' => 'საიტის შეცვლა'],
    ];
}


function collapsedRoutes(){
    return [
        'user.home', 'user.profile', 'user.mydocs', 'admin.blog'
    ];
}


function dval($a){
    return doubleval($a);
}




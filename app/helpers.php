<?php

use App\Helperclass\SiteJson;

function getUrl(){
    return  \Illuminate\Support\Facades\URL::full();
}

/**
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */

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
        ['route' => 'user.mydocs', 'icon' => 'nc-icon nc-single-copy-04', 'name' => 'ობიექტები'],
        ['route' => 'user.questions', 'icon' => 'nc-icon nc-tap-01', 'name' => 'კითხვარი']

    ];
}

function adminRoutes()
{
    return [
        ['route' => 'admin.docs', 'icon' => 'nc-icon nc-paper', 'name' => 'დოკუმენტები'],
        ['route' => 'admin.users', 'icon' => 'far fa-user-friends', 'name' => 'მომხმარებლები'],
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

function siteLogo(){
    if (session()->has('site-logo')){
        return session()->get('site-logo');
    }

    $logo = (new SiteJson())->siteLogo();

    session()->put('site-logo', $logo);

    return $logo;
}

function toolbarRoutes(){
    return ['danger.show'];
}

function nbackRoutes(){
    return [
        'blog.edit','home', 'user.profile', 'user.mydocs'
    ];
}

function searchInvisible() {
    return [
        'user.mydocs'
    ];
}

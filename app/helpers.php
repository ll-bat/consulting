<?php

use App\Helperclass\SiteJson;
use Illuminate\Support\Facades\App;

function getUrl()
{
    return \Illuminate\Support\Facades\URL::full();
}

/**
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */

function current_user()
{
    return auth()->user();
}

function index($array, $key): array
{
    $res = [];
    foreach ($array as $item) {
        $res[$item[$key]] = $item;
    }
    return $res;
}

function testBack()
{
    return asset('storage/backgrounds/background.png');
}

function getAvatar()
{
    if (auth()->user()) return current_user()->pathAvatar();
    return asset('storage/avatars/avatar.png');
}

function getTestFolder()
{
    return asset('/storage/icons/folder1.png');
}

function userRoutes()
{
    // ['route' => '', 'icon' => 'nc-icon nc-diamond', 'name' => 'Skills'],
    //     ['route' => '', 'icon' => 'nc-icon nc-pin-3', 'name' => 'Location'],

    return [
        ['route' => 'user.home', 'icon' => 'nc-icon nc-bank', 'name' => __("მთავარი")],
        ['route' => 'user.profile', 'icon' => 'nc-icon nc-single-02', 'name' => __("პროფილი")],
        ['route' => 'user.objects', 'icon' => 'nc-icon nc-single-copy-04', 'name' => __("ობიექტები")],
        ['route' => 'user.preQuestions', 'icon' => 'nc-icon nc-tap-01 mr-3 mt-3 ml-1', 'name' => __("რისკების შეფასების დოკუმენტის შექმნა")],
    ];
}

function adminRoutes()
{
    return [
        ['route' => 'admin.fields', 'icon' => 'nc-icon nc-paper', 'name' => __("დოკუმენტები")],
        ['route' => 'admin.users', 'icon' => 'far fa-user-friends', 'name' => __("მომხმარებლები")],
        ['route' => 'admin.blog', 'icon' => 'nc-icon nc-tag-content', 'name' => __("ბლოგები")],
        ['route' => 'admin.customize', 'icon' => 'nc-icon nc-ruler-pencil', 'name' => __("საიტის შეცვლა")],
    ];
}


function collapsedRoutes()
{
    return [
        'user.home', 'user.profile', 'user.objects', 'admin.blog'
    ];
}


function dval($a)
{
    return doubleval($a);
}

function siteLogo()
{
    if (session()->has('site-logo')) {
        return session()->get('site-logo');
    }

    $logo = (new SiteJson())->siteLogo();

    session()->put('site-logo', $logo);

    return $logo;
}

function toolbarRoutes()
{
    return ['danger.show'];
}

function nbackRoutes()
{
    return [
        'blog.edit', 'home', 'user.profile', 'user.objects'
    ];
}

function searchInvisible()
{
    return [
    ];
}

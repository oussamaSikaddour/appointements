@extends('layouts.default-layout')
@section('pageContent')


    <div class="dashboard__links">
     <x-manage-landing.link route="general_infos" img="manageLanding/admin.png" :label=" __('pages.general_infos.name')" />
     <x-manage-landing.link route="manage_hero" img="manageLanding/landing-page.png" :label=" __('pages.manage_hero.name')" />
     <x-manage-landing.link route="manage_about_us" img="manageLanding/admin.png" :label=" __('pages.manage_about_us.name')" />
     <x-manage-landing.link route="manage_our_qualities" img="manageLanding/admin.png" :label=" __('pages.manage_our_qualities.name')" />
     <x-manage-landing.link route="manage_socials" img="manageLanding/social-media.png" :label=" __('pages.manage_socials.name')" />
    </div>




@endsection




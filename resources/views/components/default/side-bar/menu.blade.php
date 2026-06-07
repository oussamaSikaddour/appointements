<div class="menu">
    <ul id="mainMenu" role="menu" aria-labelledby="menubutton" class="menu__items">

        @can('super-admin-access')
         <x-default.side-bar.item
        route="wilayates"
       :routeName="__('pages.wilayates.name')"
        icon="wilaya"
     />
         <x-default.side-bar.item
        route="occupation_fields"
       :routeName="__('pages.occupation_fields.name')"
        icon="field"
     />
        <x-default.side-bar.item
        route="banks"
       :routeName="__('pages.banks.name')"
        icon="bank"
     />
        <x-default.side-bar.item
        route="landing_page"
       :routeName="__('pages.manage_landing.name')"
        icon="landing"
     />
        <x-default.side-bar.item
        route="messages"
       :routeName="__('pages.messages.name')"
        icon="message"
     />

     @endcan
        @can('admin-access')

        <x-default.side-bar.item
        route="menus_route"
       :routeName="__('pages.menus.name')"
        icon="menu"
     />
        <x-default.side-bar.item
        route="sliders_route"
       :routeName="__('pages.sliders.name')"
        icon="slider"
     />
     @endcan

        @can('author-access')

        <x-default.side-bar.item
        route="articles_route"
       :routeName="__('pages.articles.name')"
        icon="article"
     />
        <x-default.side-bar.item
        route="trends_route"
       :routeName="__('pages.trends.name')"
        icon="trend"
     />
     @endcan
    </ul>
</div>


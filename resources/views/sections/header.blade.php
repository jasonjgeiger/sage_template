<header class="banner flex flex-row">
  <div class="flex-1">
    <a class="brand text-green text-md font-titillium font-black" href="{{ home_url('/') }}">
      {!! $siteName !!}
    </a>
  </div>
  <div class="flex-1">
    @if (has_nav_menu('primary_navigation'))
      <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav flex', 'echo' => false]) !!}
      </nav>
    @endif
  </div>
</header>
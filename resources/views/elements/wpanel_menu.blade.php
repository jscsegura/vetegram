<div class="page-sidebar" id="main-menu">

    @php $menus = session()->get('wpmenus') @endphp

    <ul>
        <li class="start"><a href="{{ route('wp.home') }}"><i class="fas fa-home"></i><span class="title">Inicio</span></a></li>
        @if(!empty($menus))
        @foreach ($menus as $menu)
            @if(count($menu->submenu) > 0)
                <li>
                    <a href="javascript:;">
                        <i class="fas {{ $menu->icon }}"></i>
                        <span class="title">{{ $menu->title }}</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        foreach ($menu->submenu as $submenu) {
                            ?><li><a href="{{ route($submenu->route) }}">{{ $submenu->title }}</a></li><?php
                        }
                        ?>
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ route($menu->route) }}">
                        <i class="fas {{ $menu->icon }}"></i>
                        <span class="title">{{ $menu->title }}</span>
                    </a>
                </li>
            @endif
        @endforeach
        @endif
    </ul>
    <a href="#" class="scrollup">Scroll</a>
    <div class="clearfix"></div>
</div>
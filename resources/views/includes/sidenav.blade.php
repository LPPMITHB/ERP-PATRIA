@php
    if(Request::Segment(2) == "" || Request::Segment(2) > 0 ){
        $route = (Request::segment(1)).'.index';
    }else{
        $route = (Request::segment(1)).'.'.(Request::segment(2));
    }   

    $menuInfo = array(
        'parent3' => null,
        'parent2' => null,
        'parent1' => null,
        'child' => null,
    ); 
    foreach ($sidenavs as $menu) {
        if($menu->route_name == $route ){
            $menuInfo['child'] = $menu->menu_id;
            if($menu->menu->menu){
                $menuInfo['parent1'] = $menu->menu->menu->id;
                if($menu->menu->menu->menu){
                    $menuInfo['parent2'] = $menu->menu->menu->menu->id;
                    if($menu->menu->menu->menu->menu){
                        $menuInfo['parent3'] = $menu->menu->menu->menu->menu->id;       
                    }
                }
            }
        }else{
            if($route == ".index"){
                $menuInfo['child'] = 1;
            }
        }
    }

@endphp
<section class="sidebar">
<ul class="sidebar-menu" data-widget="tree">
@foreach($menus as $menu)
    <?php
        $roles = explode(',',$menu->roles);
        $status = 0;
        foreach($roles as $role){
            if($role == $roleUser){
                $status = 1;
            }
        }
    ?>
    @if($status ==1)
        @if($menu->menus->count() > 0 && $menu->level ==1)
            <li class="treeview {{ $menu->id == $menuInfo['parent3'] ? 'active' : $menu->id == $menuInfo['parent2'] ? 'active' : $menu->id == $menuInfo['parent1'] ? 'active' : '' }}" data-toggle="tooltip" title="{{ $menu->name }}" data-container="body" data-placement="right">
                <a href="#" >
                    <i class="fa {{ $menu->icon }}"></i>
                    @if(strlen($menu->name) > 22)
                        <span>{{ substr($menu->name, 0, 22) }}...</span>
                    @else
                        <span>{{ $menu->name }}</span>
                    @endif
                </a>
                <ul class="treeview-menu">
                    @foreach($menu->menus as $menu2)
                        <?php
                            $roles = explode(',',$menu2->roles);
                            $status = 0;
                            foreach($roles as $role){
                                if($role == $roleUser){
                                    $status = 1;
                                }
                            }
                        ?>
                        @if($status ==1)
                            @if($menu2->menus->count() > 0)
                                <li class="treeview {{ $menu2->id == $menuInfo['parent2'] ? 'active' : $menu2->id == $menuInfo['parent1'] ? 'active' : ''  }} " data-toggle="tooltip" title="{{ $menu2->name }}" data-container="body" data-placement="right">
                                    <a href="#" ><i class="fa {{ $menu2->icon }}"></i>
                                        @if(strlen($menu2->name) > 18)
                                            <span>{{ substr($menu2->name, 0, 18) }}...</span>
                                        @else
                                            <span>{{ $menu2->name }}</span>
                                        @endif
                                    </a>
                                    <ul class="treeview-menu">
                                        @foreach($menu2->menus as $menu3)
                                            <?php
                                                $roles = explode(',',$menu3->roles);
                                                $status = 0;
                                                foreach($roles as $role){
                                                    if($role == $roleUser){
                                                        $status = 1;
                                                    }
                                                }
                                            ?>
                                            @if($status ==1)     
                                                @if($menu3->menus->count() > 0)
                                                    <li class="treeview {{ $menu3->id == $menuInfo['parent1'] ? 'active' : '' }} " data-toggle="tooltip" title="{{ $menu3->name }}" data-container="body" data-placement="right">
                                                        <a href="#" ><i class="fa {{ $menu3->icon }}"></i>
                                                            @if(strlen($menu3->name) > 18)
                                                                <span>{{ substr($menu3->name, 0, 18) }}...</span>
                                                            @else
                                                                <span>{{ $menu3->name }}</span>
                                                            @endif
                                                        </a>
                                                        <ul class="treeview-menu">
                                                            @foreach($menu3->menus as $menu4)
                                                                <?php
                                                                    $roles = explode(',',$menu4->roles);
                                                                    $status = 0;
                                                                    foreach($roles as $role){
                                                                        if($role == $roleUser){
                                                                            $status = 1;
                                                                        }
                                                                    }
                                                                ?>
                                                                @if($status ==1)                     
                                                                    <li class="{{ $menu4->id == $menuInfo['child'] ? 'active' : '' }}" data-toggle="tooltip" title="{{ $menu4->name }}" data-container="body" data-placement="right"><a href="{{ route($menu4->route_name)}}"><i class="fa {{ $menu4->icon }}" ></i>
                                                                    @if(strlen($menu4->name) > 12)
                                                                        <span>{{ substr($menu4->name, 0, 12) }}...</span>
                                                                    @else
                                                                        <span>{{ $menu4->name }}</span>
                                                                    @endif
                                                                    </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    @foreach($child as $child1)
                                                        <?php
                                                            $roles = explode(',',$child1->roles);
                                                            $status = 0;
                                                            foreach($roles as $role){
                                                                if($role == $roleUser){
                                                                    $status = 1;
                                                                }
                                                            }
                                                        ?>
                                                        @if($status ==1)   
                                                            @if($menu3->id == $child1->id)
                                                                <li class="{{ $menu3->id == $menuInfo['child'] ? 'active' : '' }}" data-toggle="tooltip" title="{{ $menu3->name }}" data-container="body" data-placement="right">
                                                                    <a href="{{ Route::has($menu3->route_name) ? route($menu3->route_name) : '#' }}">
                                                                    <i class="fa {{ $menu3->icon }}"></i> 
                                                                    @if(strlen($menu3->name) > 18)
                                                                        <span>{{ substr($menu3->name, 0, 18) }}...</span>
                                                                    @else
                                                                        <span>{{ $menu3->name }}</span>
                                                                    @endif
                                                                </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @foreach($child as $child1)
                                    <?php
                                        $roles = explode(',',$child1->roles);
                                        $status = 0;
                                        foreach($roles as $role){
                                            if($role == $roleUser){
                                                $status = 1;
                                            }
                                        }
                                    ?>
                                    @if($status ==1)   
                                        @if($menu2->id == $child1->id)
                                            <li class="{{ $menu2->id == $menuInfo['child'] ? 'active' : '' }}" data-toggle="tooltip" title="{{ $menu2->name }}" data-container="body" data-placement="right">
                                            <a href="{{ Route::has($menu2->route_name) ? route($menu2->route_name) : '#' }}">
                                                <i class="fa {{ $menu2->icon }}"></i> 
                                                @if(strlen($menu2->name) > 18)
                                                    <span>{{ substr($menu2->name, 0, 18) }}...</span>
                                                @else
                                                    <span>{{ $menu2->name }}</span>
                                                @endif
                                            </a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach
                </ul>
            </li>
        @else
            @if($menu->level ==1)
                <li class="{{ $menu->id == $menuInfo['child'] ? 'active' : '' }}" data-toggle="tooltip" title="{{ $menu->name }}" data-container="body" data-placement="right">
                    <a href="{{ Route::has($menu->route_name) ? route($menu->route_name) : '#' }}" >
                        <i class="fa {{ $menu->icon }}"></i> 
                        @if(strlen($menu->name) > 22)
                            <span>{{ substr($menu->name, 0, 22) }}...</span>
                        @else
                            <span>{{ $menu->name }}</span>
                        @endif
                        <span class="pull-right-container">
                        </span>
                    </a>
                </li>
            @endif
        @endif
    @endif
@endforeach
</ul>
</section>

@push('script')
<script>
    $(document).on('show.bs.tooltip', function() {
        // Only one tooltip should ever be open at a time
        $('.tooltip').not(this).hide();
    });
</script>
@endpush

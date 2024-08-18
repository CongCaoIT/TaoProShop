@php
    $segment = request()->segment(1);
@endphp
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ Auth::user()->image }}" width="60px" height="60px" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{ Auth::user()->user_catalogues->name }} <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="https://caotancong.tcshop.id.vn/" target="_blank">Thông tin cá nhân</a></li>
                        <li><a href="contacts.html">Liên Hệ</a></li>
                        <li><a href="mailbox.html">Mail</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            @foreach (__('sidebar.module') as $key => $val)
                <li class="{{ in_array($segment, $val['name']) ? 'active' : '' }}">
                    <a href="#"><i class="{{ $val['icon'] }}"></i><span class="nav-label">{{ $val['title'] }}</span> <span
                            class="fa arrow"></span></a>
                    @if (isset($val['subModule']))
                        <ul class="nav nav-second-level">
                            @foreach ($val['subModule'] as $item)
                                <li><a href="{{ route($item['route']) }}">{{ $item['title'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>

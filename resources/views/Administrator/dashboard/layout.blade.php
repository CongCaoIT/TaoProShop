<!DOCTYPE html>
<html>

<head>
    @include('Administrator.dashboard.component.head') {{-- head --}}
</head>

<body>
    <div id="wrapper">
        @include('Administrator.dashboard.component.sidebar') {{-- sidebar --}}
        <div id="page-wrapper" class="gray-bg">
            @include('Administrator.dashboard.component.nav') {{-- nav --}}
            
            @include($template) {{-- Content --}}

            @include('Administrator.dashboard.component.footer') {{-- footer --}}
        </div>
        @include('Administrator.dashboard.component.rightsidebar') {{-- rightsiderbar --}}
    </div>

    @include('Administrator.dashboard.component.script') {{-- script --}}
</body>

</html>

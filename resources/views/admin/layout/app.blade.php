<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

@include('admin.layout.head')

<body>

    <div class="main-wrapper">

        @include('admin.layout.header')

        @include('admin.layout.sidebar')


        <div class="page-wrapper">
            @yield('body')
        </div>
    </div>





    @include('admin.layout.script')
</body>

</html>

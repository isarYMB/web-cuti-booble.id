<!DOCTYPE html>
<html lang="en">
@include('includes.header')
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
        {{-- @include('includes.navbar') --}}

        @include('includes.sidebar')
      
        @yield('content')

        @include('includes.footer')

    </div>
  </div>
  
  @yield('script')
  @include('includes.script')



</body>


<!-- Mirrored from radixtouch.com/templates/admin/aegis/source/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jul 2021 09:55:44 GMT -->
</html>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>

  @include('include.style')

  @include('include.script')

</head>

<body>

  @include('include.header')

  @include('include.sidebar')


  <div id="contentRef" class="content">

    @yield('content')

  </div>

  @yield('script')

</body>

</html>
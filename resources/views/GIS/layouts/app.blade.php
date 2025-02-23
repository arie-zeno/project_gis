<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }} </title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- Cluster --}}
    {{-- cluster --}}
    <link rel="stylesheet" href="js/Leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="/js/Leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <script src="/js/Leaflet.markercluster/dist/leaflet.markercluster-src.js"></script>
    <link rel="stylesheet" href="/js/treeLayer/L.Control.Layers.Tree.css">
    <script src="/js/treeLayer/L.Control.Layers.Tree.js"></script>

    {{-- slide menu --}}
    {{-- Slide --}}
    <link rel="stylesheet" href="/css/L.Control.SlideMenu.css">
    <script src="/js/L.Control.SlideMenu.js"></script>

    <style>
        body {
            /* background-image: url('/img/bg2.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center */
            background-color: #eaeaea;
        }
    </style>

</head>

<body>
    <main>
        @include('sweetalert::alert') <!-- Tambahkan ini -->
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    @yield('js')
</body>


</html>

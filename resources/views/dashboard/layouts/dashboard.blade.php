@extends('dashboard.layouts.app')
<style>
    .nav-item:hover {
        background: linear-gradient(135deg, #415884, #6a11cb);
        border-radius: 10px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(3.7px);
        -webkit-backdrop-filter: blur(3.7px);
        transform: scale(1.01);
        margin-left: 10px;
        font-size: 1.2em;
        color: #fff
    }

    .nav-item:hover a {
        color: #fff;
    }

    .nav-item {
        transition: 0.2s;
    }

    .nav-item a {
        color: black
    }

    .active-nav {
        background: linear-gradient(135deg, #415884, #6a11cb);
        border-radius: 10px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(3.7px);
        -webkit-backdrop-filter: blur(3.7px);
        transform: scale(1.01);
        margin-left: 10px;
        font-size: 1.2em;
        color: #fff
    }

    .active-nav a {
        color: #fff;
    }

    #logout {
        transition: 0.2s;
    }

    #logout:hover {
        transform: scale(1.1);

    }

    a.link-tambah {
        background: linear-gradient(135deg, #415884, #6a11cb);
        padding: 5px 10px;
        border-radius: 10px;
        text-decoration: none;
        color: white;
        transition: 0.2s;
    }

    a.link-tambah:hover {
        transform: scale(1.1);
    }
</style>
@section('content')
    <div class="d-flex flex-column" style="min-height: 100vh;">


        <div class="d-flex flex-grow-1">
            <!-- Sidebar -->
            <div id="sidebar" class=" text-dark vh-100 "
                style="width: 250px; transition: transform 0.3s; z-index: 999;background: #fff; position: sticky; top: 0">
                <div class="d-flex justify-content-between align-items-center mb-2 p-3"
                    style="background: linear-gradient(135deg, #415884, #6a11cb)">
                    <a href="{{ route('gis.home') }}" class="text-decoration-none">
                        <h4 class="text-light">PILKOM GIS</h4>
                    </a>
                    <!-- Tombol Toggle Sidebar (Selalu ditampilkan) -->
                    <button id="toggleSidebar" class="btn btn-link  p-0">
                        <i id="sidebarIcon" class="bi bi-arrow-bar-left" style="font-size: 1.5rem;color:#fff"></i>
                    </button>
                </div>
                <ul class="nav flex-column">
                    @if (auth()->user()->role != 'admin')
                        <li class="mb-1 nav-item @php echo $title == "Dashboard" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('mahasiswa.home') }}" class="nav-link "><i class="bi bi-house-fill me-2"></i>
                                Utama</a>
                        </li>

                        <li class="mb-1 nav-item @php echo $title == "Biodata" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('mahasiswa.biodata') }}" class="nav-link "><i
                                    class="bi bi-people-fill me-2"></i>
                                Biodata</a>s
                        </li>

                        <li class="mb-1 nav-item @php echo $title == "Sekolah" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('mahasiswa.sekolah') }}" class="nav-link "><i
                                    class="bi bi-mortarboard-fill me-2"></i>
                                Sekolah</a>
                        </li>

                        <li class="mb-1 nav-item @php echo $title == "Domisili" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('mahasiswa.tempat') }}" class="nav-link "><i
                                    class="bi bi-house-heart-fill me-2"></i>
                                Domisili</a>
                        </li>
                    @else
                        <li class="mb-1 nav-item @php echo $title == "Dashboard" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link "><i class="bi bi-house-fill me-2"></i>
                                Utama</a>
                        </li>

                        <li class="mb-1 nav-item @php echo $title == "Mahasiswa" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('admin.mahasiswa') }}" class="nav-link "><i
                                    class="bi bi-person-fill me-2"></i> Mahasiswa</a>
                        </li>

                        <li class="mb-1 nav-item @php echo $title == "Sekolah" ? "active-nav" : ""; @endphp">
                            <a href="{{ route('admin.sekolah') }}" class="nav-link "><i
                                    class="bi bi-mortarboard-fill me-2"></i> Sekolah</a>
                        </li>
                    @endif
                </ul>
            </div>


            <!-- Overlay untuk mobile (Muncul saat sidebar dibuka di mobile) -->
            <div id="overlay" class="d-none"
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 998;">
            </div>

            <!-- Konten -->

            <div id="content" class="flex-grow-1 p-3" style=" transition: margin 0.3s; overflow-x: hidden;">
                <!-- Area Konten -->
                <div class="container-fluid">

                    <!-- Navbar Atas -->
                    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm rounded mb-3" style="background: #fff">
                        <div class="container-fluid">
                            <!-- Tombol Buka Sidebar (Muncul saat sidebar tertutup di desktop dan mobile) -->
                            <button id="openSidebar" class="btn btn-link text-dark me-3 d-none">
                                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                            </button>

                            <!-- Brand/Logo -->
                            <a class="navbar-brand fw-bold" href="#"
                                style="background: linear-gradient(135deg, #415884, #6a11cb); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">{{ auth()->user()->name }}</a>

                            <!-- Tombol Logout -->
                            <div>
                                <form id="logout" action="{{ route('logout') }}" method="POST"
                                    class="d-flex flex-column mb-0 rounded justify-content-center align-items-center"
                                    style="background: linear-gradient(135deg, #415884, #6a11cb); color:#fff">
                                    @csrf
                                    <button type="submit" class="btn text-light" placeholder="logout">Logout</button>
                                </form>
                            </div>
                        </div>
                    </nav>

                    @yield('dashboard-content')
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk toggle sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const openSidebarButton = document.getElementById('openSidebar');
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const overlay = document.getElementById('overlay');

        // Fungsi untuk membuka sidebar
        function openSidebar() {
            if (window.innerWidth <= 992) { // Mode mobile
                sidebar.style.transform = 'translateX(0)';

                overlay.classList.remove('d-none');
            } else { // Mode desktop
                sidebar.style.transform = 'translateX(0)';
            }
            openSidebarButton.classList.add('d-none');
        }

        // Fungsi untuk menutup sidebar
        function closeSidebar() {
            if (window.innerWidth <= 992) { // Mode mobile
                sidebar.style.transform = 'translateX(-100%)';
                overlay.classList.add('d-none');
                openSidebarButton.classList.remove('d-none');
            } else { // Mode desktop
                sidebar.style.transform = 'translateX(-100%)';
            }
        }

        // Event listener untuk tombol toggle sidebar
        toggleSidebarButton.addEventListener('click', closeSidebar);

        // Event listener untuk tombol buka sidebar di navbar
        openSidebarButton.addEventListener('click', openSidebar);

        // Event listener untuk overlay (menutup sidebar saat overlay diklik)
        overlay.addEventListener('click', closeSidebar);

        // Menutup sidebar secara default saat di mobile
        if (window.innerWidth <= 992) {
            sidebar.style.position = "fixed"
            closeSidebar();

        } else {
            toggleSidebarButton.classList.add('d-none');
            closeSidebar.classList.add('d-none');

        }
    </script>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Styling dasar untuk halaman login */
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f2f5;
    }

    .login-container {
        width: 300px;
        padding: 50px;
        background-color: #fff;
        border: 1.5px solid #222e64; /* border gelap agar terlihat */
        box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        text-align: center;
        position: relative;
        z-index: 10;
    }

    h2 {
        margin-bottom: 20px;
        color: #222e64;
    }

    label {
        display: block;
        text-align: left;
        font-weight: bold;
        margin-bottom: 5px;
        color: #222e64;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #33438d;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover {
        background-color: #222e64;
    }

    .error {
        color: red;
        margin-bottom: 15px;
    }
    </style>
    <style>
        canvas{ display: block; vertical-align: bottom; } /* ---- particles.js container ---- */ 
        #particles-js{ position:absolute; width: 100%; height: 100%; background-color: #ffffff; background-image: url(""); background-repeat: no-repeat; background-size: cover; background-position: 50% 50%; z-index: 0;} /* ---- stats.js ---- */ 
        .count-particles{ background: #000022; position: absolute; top: 48px; left: 0; width: 80px; color: #13E8E9; text-align: left; text-indent: 4px; line-height: 14px; padding-bottom: 2px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; } 
        .js-count-particles{ font-size: 1.1em; } #stats, .count-particles{ -webkit-user-select: none; margin-top: 5px; margin-left: 5px; } #stats{ border-radius: 3px 3px 0 0; overflow: hidden; } .count-particles{ border-radius: 0 0 3px 3px; }
    </style>

</head>
<body>
    <!-- particles.js container --> <div id="particles-js"></div> <!-- stats - count particles --><!-- particles.js lib - https://github.com/VincentGarreau/particles.js --> <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- stats.js lib --> <script src="http://threejs.org/examples/js/libs/stats.min.js"></script> 

    @if (@session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role='alert'>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif

        @if (@session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role='alert'>
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif
    <div class="login-container">

        <h2>Login</h2>
        <form method="POST" action="/login">
            @include('sweetalert::alert')

            @csrf
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" @error('email') is-invalid @enderror autofocus required value='{{ old('email') }}'><br><br>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <button type="submit">Login</button>
        </form>
    </div>
        <script>
            particlesJS("particles-js", {"particles":{"number":{"value":80,"density":{"enable":true,"value_area":800}},"color":{"value":"#222e64"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#222e64","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
        </script>
</body>
</html>
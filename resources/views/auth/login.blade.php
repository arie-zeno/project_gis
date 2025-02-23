<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* public/css/login.css */
        body {

            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        main {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        .left-section {
            flex: 1;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .left-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .left-section p {
            font-size: 1.2rem;
            margin-bottom: 40px;
        }

        .left-section .features {
            text-align: left;
            margin-left: 20px;
        }

        .left-section .features ul {
            list-style-type: none;
            padding: 0;
        }

        .left-section .features ul li {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .right-section {
            flex: 1;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
            text-align: left;
        }

        .login-container input {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container input:focus {
            border-color: #6a11cb;
            outline: none;
        }

        .login-container button {
            padding: 10px;
            background: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-container button:hover {
            background: #2575fc;
        }

        .error-message {
            color: #ff4d4d;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .login-container .options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .login-container .options a {
            color: #6a11cb;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container .options a:hover {
            text-decoration: underline;
        }

        .login-container .social-login {
            margin-bottom: 20px;
        }

        .login-container .social-login button {
            width: 100%;
            padding: 10px;
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .login-container .social-login button img {
            margin-right: 10px;
        }

        .login-container .social-login button:hover {
            background: #f0f2f5;
        }

        .login-container .signup-link {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .login-container .signup-link a {
            color: #6a11cb;
            text-decoration: none;
        }

        .login-container .signup-link a:hover {
            text-decoration: underline;
        }

        /* Media Queries untuk Tampilan Mobile */
        @media (max-width: 768px) {
            .left-section {
                display: none;
                /* Sembunyikan bagian kiri di mode mobile */
            }

            .right-section {
                flex: 1;
                padding: 10px;
            }

            .login-container {
                padding: 20px;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <main>


        <div class="left-section">
            <div>
                <h1>Hello Again!</h1>
                <p>Aliquam consetetur et tincidunt present enim massa</p>
                <div class="features">
                    <ul>
                        <li>Easy To Navigate</li>
                        <li>And Earn Rewards</li>
                        <li>Now you can make reservations and compete against other users.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="right-section">
            <div class="login-container">
                <h2>Login</h2>
                {{-- @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Contoh : user@gmail.com" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>

                    <div class="options">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                        <a href="#">Recovery Password</a>
                    </div>

                    <button type="submit">Login</button>
                </form>


                <div class="signup-link">
                    Don't have an account yet? <a href="#">Sign Up</a>
                </div>
            </div>

        </div>
    </main>

</body>

</html>

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
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        text-align: left;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
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
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error {
        color: red;
        margin-bottom: 15px;
    }
    </style>

</head>
<body>
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
</body>
</html>
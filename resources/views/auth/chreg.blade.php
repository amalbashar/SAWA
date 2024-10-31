
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Registration Type</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .choose-container {
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
        }
        .choose-container h2 {
            color: #8A4DFF;
            font-size: 24px;
            margin-bottom: 20px
        }
        .choose-btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #8A4DFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .choose-btn:hover {
            background-color: #6C3CCF;
        }
        .login-link {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #8A4DFF;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
            color: #6C3CCF;
        }
    </style>
</head>
<body>
    <div class="choose-container">
        <h2>Register as:</h2>
        <a href="{{ route('register.user') }}" class="choose-btn">User</a>
        <a href="{{ route('register.careprovider') }}" class="choose-btn">Care Provider</a>
        {{-- <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}"> Login</a></p> --}}
    </div>
</body>
</html>

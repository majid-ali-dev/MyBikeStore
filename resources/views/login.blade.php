<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyBikeStore</title>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            /* background: url("{{ asset('images/istockphot6.jpg') }}") center center / cover no-repeat fixed; */
            position: relative;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 20px;
            text-align: center;
        }

        .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .card h4 {
            margin-bottom: 8px;
            font-size: 24px;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .form-label {
            font-weight: bold;
            color: #333;
            display: block;
            text-align: start;
            margin-bottom: 5px;
        }

        .form-control {
            width: 93%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-google {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 95%;
            padding: 10px;
            border: 1px solid #db4a39;
            border-radius: 5px;
            color: #fff;
            background-color: #db4a39;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 5px;
        }

        .btn-google i {
            margin-right: 8px;
        }

        .btn-google:hover {
            background-color: #c33d2b;
        }

        .card-footer {
            margin-top: 10px;
        }

        .card-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        .acc {
            color: black;
        }

        /* create and supervisor decoration portion start from here */
        .creator {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            text-align: center;
            color: #f8f9fa;
            /* Light gray text */
            font-weight: 500;
            background: rgba(0, 0, 0, 0.7);
            /* Semi-transparent dark background */
            padding: 7px 12px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            /* Subtle shadow */
            line-height: 1.3;
        }

        .creator span {
            color: #17a2b8;
            /* Highlight names and titles in a professional blue */
            font-weight: 550;
        }

        .creator:hover {
            background: rgba(0, 0, 0, 0.9);
            /* Slightly darker on hover */
            color: #ffffff;
            /* Pure white text on hover */
            transition: all 0.3s ease;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="card">
            {{-- <img src="{{ asset('images/istockphot204.jpg') }}" alt="Logo"> --}}
            <span style="color:#db4a39"><h1><i class="fas fa-motorcycle me-2"></i></h1></span>
            <h4>MyBikeStore</h4>
            <p>Please login to your account</p>
            <form action="{{ route('loginMatch') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">&nbsp; Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">&nbsp; Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-primary">Login</button>
            </form>

            <a href="{{ route('google.login') }}" class="btn btn-google">
                <i class="fa-brands fa-google"></i> Login with Google
            </a>


            <div class="card-footer">
            <small class="acc">Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    {{-- <script>
        @if (Session::has('alertType'))
            Swal.fire({
                icon: '{{ Session::get('alertType') }}',
                title: '{{ Session::get('alertTitle') }}',
                text: '{{ Session::get('alertMessage') }}',
                confirmButtonColor: '#007bff',
                timer: 5000,
                timerProgressBar: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid email or password',
                confirmButtonColor: '#dc3545'
            });
        @endif
    </script> --}}
</body>

</html>

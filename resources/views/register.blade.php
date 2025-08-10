<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyBikeStore - Create Account</title>
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
            min-height: 100vh;
            padding: 20px 15px;
            color: white;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 420px;
            width: 100%;
            padding: 20px;
            text-align: center;
            margin: auto;
        }

        .card-header {
            margin-bottom: 20px;
        }

        .card-header h4 {
            margin-bottom: 8px;
            font-size: 24px;
            color: #333;
        }

        .card-header p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
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
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-footer {
            margin-top: 15px;
            font-size: 14px;
        }

        .card-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
            text-align: left;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .acc {
            color: black;
        }

        /* Creator section styling */
        .creator {
            display: block;
            margin-top: 15px;
            font-size: 12px;
            text-align: center;
            color: #f8f9fa;
            font-weight: 500;
            background: rgba(0, 0, 0, 0.7);
            padding: 7px 12px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.3;
        }

        .creator span {
            color: #17a2b8;
            font-weight: 550;
        }

        .creator:hover {
            background: rgba(0, 0, 0, 0.9);
            color: #ffffff;
            transition: all 0.3s ease;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <span style="color:#db4a39">
                    <h1><i class="fas fa-motorcycle me-2"></i></h1>
                </span>
                <h4>MyBikeStore</h4>
                <p>Fill in the details to get started</p>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="card-body">
                <form action="{{ route('registerSave') }}" method="POST">
                    @csrf

                    <!-- Name Field -->
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Enter your password (min 5 characters)"
                            required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Confirm your password" required>
                    </div>

                    <!-- Phone Field -->
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div class="form-group">
                        <label class="form-label">Complete Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                            placeholder="Enter your address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary">Register</button>
                </form>
            </div>

            <div class="card-footer">
                <small class="acc">Already have an account? <a href="{{ route('login') }}">Login here</a></small>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach`,
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Account</title>
    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url("{{ asset('images/istockphot6.jpg') }}") center center / cover no-repeat fixed;
            position: relative;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 15px;
            margin: 0;
            box-sizing: border-box;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 420px;
            width: 100%;
            padding: 20px;
            margin: 0 auto;
            text-align: center;
            overflow: auto;
            max-height: 95vh;
        }

        .card-header {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            display: block;
        }

        .card-header h3 {
            font-size: 24px;
            margin: 10px 0 5px 0;
            color: #333;
        }

        .card-header p {
            font-size: 14px;
            color: #555;
            margin: 0 0 10px 0;
        }

        .form-label {
            font-weight: bold;
            color: #333;
            text-align: start;
            display: block;
            margin-bottom: 5px;
        }

        .dec {
            text-align: start;
            margin-bottom: 15px;
        }

        .form-control,
        .form-select {
            width: 93%;
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-select {
            width: 100%;
            background-color: white;
            cursor: pointer;
        }

        .form-select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            text-align: left;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .form-check-label {
            font-size: 14px;
            color: #333;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
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

        .ar {
            padding: 10px;
            margin: 10px;
            font-size: 14px;
        }

        .creator {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            text-align: center;
            color: #f8f9fa;
            font-weight: 500;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 22px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.5;
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

        /* Ensure proper scrolling for small screens */
        @media (max-height: 800px) {
            .card {
                max-height: 90vh;
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create Account</h3>
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
                    <div class="dec">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="dec">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="dec">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Enter your password (min 8 characters)"
                            required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="dec">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Confirm your password" required>
                    </div>

                    <!-- Phone Field -->
                    <div class="dec">
                        <label class="form-label">Phone Number (Optional)</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div class="dec">
                        <label class="form-label">Address (Optional)</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                            placeholder="Enter your address">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Register</button>
                </form>
            </div>

            <div class="card-footer">
                <small class="ar">Already have an account? <a href="{{ route('login') }}">Login here</a></small>
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

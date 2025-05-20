<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyBikeStore')</title>
    <!-- Add this before your @stack('scripts') -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    @stack('styles')
</head>

<body>
    <!-- Message Container - Will show all types of messages -->
    <div id="message-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; width: 300px;">
        <!-- Session Success Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Session Error Messages -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div id="app">
        <!-- Add overlay div -->
        <div class="sidebar-overlay"></div>

        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-dismiss alerts after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Sidebar toggle code remains the same...
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            function updateToggleVisibility() {
                if (sidebar.classList.contains('show')) {
                    toggleBtn.classList.add('d-none');
                } else {
                    toggleBtn.classList.remove('d-none');
                }
            }

            updateToggleVisibility();

            toggleBtn?.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                updateToggleVisibility();
            });

            const sidebarClose = document.getElementById('sidebarClose');
            sidebarClose?.addEventListener('click', function() {
                sidebar.classList.remove('show');
                updateToggleVisibility();
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.add('show');
                    toggleBtn.classList.add('d-none');
                } else {
                    sidebar.classList.remove('show');
                    toggleBtn.classList.remove('d-none');
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyBikeStore')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    @stack('styles')
</head>

<body>
    <div id="app">
        <!-- Add overlay div -->
        <div class="sidebar-overlay"></div>

        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            function updateToggleVisibility() {
                // Sidebar is visible if it has class "show"
                if (sidebar.classList.contains('show')) {
                    toggleBtn.classList.add('d-none'); // Hide toggle button
                } else {
                    toggleBtn.classList.remove('d-none'); // Show toggle button
                }
            }

            // Run once on load
            updateToggleVisibility();

            // Add click listener to toggle button
            toggleBtn?.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                updateToggleVisibility();
            });

            // Add listener for close button inside sidebar (optional)
            const sidebarClose = document.getElementById('sidebarClose');
            sidebarClose?.addEventListener('click', function () {
                sidebar.classList.remove('show');
                updateToggleVisibility();
            });

            // Optional: Auto adjust on window resize
            window.addEventListener('resize', function () {
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

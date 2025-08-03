<div class="customer-loader-overlay">
    <div class="customer-loader-content">
        <div class="customer-spinner"></div>
        <p>Welcome back! Loading your dashboard...</p>
    </div>
</div>

<style>
    .customer-loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        color: #fff;
    }

    .customer-loader-content {
        text-align: center;
    }

    .customer-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #ff6b6b;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelector('.customer-loader-overlay').style.display = 'none';
        }, 3000);
    });
</script>

<div class="admin-loader-overlay">
    <div class="admin-loader-content">
        <div class="admin-spinner"></div>
        <p>Loading Admin Dashboard...</p>
    </div>
</div>

<style>
.admin-loader-overlay {
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
.admin-loader-content {
    text-align: center;
}
.admin-spinner {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.querySelector('.admin-loader-overlay').style.display = 'none';
    }, 3000);
});
</script>

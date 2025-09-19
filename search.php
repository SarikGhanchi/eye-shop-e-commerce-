<?php 
session_start();
include 'includes/header.php'; 
?>

<style>
    .search-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }
    .search-input-group {
        position: relative;
    }
    .search-input-group .form-control {
        padding-left: 2.5rem;
        height: 50px;
    }
    .search-input-group .search-icon {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: #6c757d;
    }
    #results {
        min-height: 200px;
    }
    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 2rem auto;
        display: none; /* Hidden by default */
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="container my-5">
    <div class="search-container text-center">
        <h2 class="mb-3">Live Product Search</h2>
        <p class="text-muted mb-4">Start typing to find the perfect eyewear for you.</p>
        <div class="search-input-group">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="search" class="form-control" placeholder="Search by name or description...">
        </div>
    </div>

    <div id="loader" class="loader"></div>
    <div id="results"></div>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function () {
    const keyword = this.value;
    const resultsContainer = document.getElementById('results');
    const loader = document.getElementById('loader');

    if (keyword.length < 2) {
        resultsContainer.innerHTML = '';
        return;
    }

    loader.style.display = 'block';
    resultsContainer.innerHTML = '';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "search_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        loader.style.display = 'none';
        if (this.status === 200) {
            resultsContainer.innerHTML = this.responseText;
        } else {
            resultsContainer.innerHTML = '<div class="alert alert-danger">An error occurred.</div>';
        }
    };
    xhr.onerror = function () {
        loader.style.display = 'none';
        resultsContainer.innerHTML = '<div class="alert alert-danger">An error occurred.</div>';
    };
    xhr.send("keyword=" + encodeURIComponent(keyword));
});
</script>

<?php include 'includes/footer.php'; ?>

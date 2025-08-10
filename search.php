<?php include 'includes/header.php'; ?>

<h2 class="mb-4">🔍 Live Product Search</h2>

<div class="mb-3">
    <input type="text" id="search" class="form-control" placeholder="Type product name...">
</div>

<div id="results"></div>

<script>
document.getElementById('search').addEventListener('keyup', function () {
    const keyword = this.value;

    if (keyword.length === 0) {
        document.getElementById('results').innerHTML = '';
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "search_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        document.getElementById('results').innerHTML = this.responseText;
    };
    xhr.send("keyword=" + encodeURIComponent(keyword));
});
</script>

<?php include 'includes/footer.php'; ?>

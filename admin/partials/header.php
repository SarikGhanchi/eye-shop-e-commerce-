<?php
session_start(); // ✅ Required to access session variables

if (!isset($_SESSION['admin_loggedin'])) {
  header("Location: ../login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Blood Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
    <div class="ms-auto">
      <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row"></div>
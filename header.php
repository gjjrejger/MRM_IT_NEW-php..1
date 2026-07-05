<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Dashboard Header
 * File: dashboard/partials/header.php
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Load Application
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../app/config/bootstrap.php';

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

if (!isLoggedIn()) {

    redirect(APP_URL . '/login.php');

}

/*
|--------------------------------------------------------------------------
| Current User
|--------------------------------------------------------------------------
*/

$currentUser = [

    'id' => $_SESSION['user_id'] ?? 0,

    'name' => $_SESSION['full_name'] ?? 'Unknown User',

    'first_name' => $_SESSION['first_name'] ?? '',

    'last_name' => $_SESSION['last_name'] ?? '',

    'username' => $_SESSION['username'] ?? '',

    'email' => $_SESSION['email'] ?? '',

    'role' => $_SESSION['role_name'] ?? '',

    'approval_level' => $_SESSION['approval_level'] ?? 0

];

/*
|--------------------------------------------------------------------------
| Page Title
|--------------------------------------------------------------------------
*/

$pageTitle = $pageTitle ?? 'Dashboard';

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>

<?= htmlspecialchars($pageTitle) ?>

|

<?= APP_NAME ?>

</title>

<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- Bootstrap Icons -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
rel="stylesheet">

<!-- Google Font -->

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Dashboard CSS -->

<link
rel="stylesheet"
href="<?= APP_URL ?>/dashboard/assets/dashboard.css">

<style>

:root{

    --sidebar-width:260px;

    --navbar-height:70px;

    --primary:#0F4C81;

    --secondary:#0066B3;

    --success:#28a745;

    --warning:#ffc107;

    --danger:#dc3545;

    --light:#f8f9fa;

    --dark:#212529;

    --card-radius:15px;

}

*{

    margin:0;

    padding:0;

    box-sizing:border-box;

    font-family:'Poppins',sans-serif;

}

body{

    background:#f4f6f9;

    overflow-x:hidden;

}

a{

    text-decoration:none;

}

.wrapper{

    display:flex;

    min-height:100vh;

}

.content-wrapper{

    flex:1;

    margin-left:var(--sidebar-width);

    display:flex;

    flex-direction:column;

    min-height:100vh;

}

.main-content{

    flex:1;

    padding:30px;

    margin-top:var(--navbar-height);

}

.card{

    border:none;

    border-radius:var(--card-radius);

    box-shadow:0 10px 25px rgba(0,0,0,.08);

}

.card-header{

    background:#fff;

    border-bottom:none;

    font-weight:600;

}

.page-title{

    font-size:28px;

    font-weight:700;

    color:#333;

}

.badge-role{

    background:var(--primary);

    color:white;

    padding:8px 14px;

    border-radius:20px;

}

@media(max-width:992px){

    .content-wrapper{

        margin-left:0;

    }

}

</style>

</head>

<body>

<div class="wrapper">
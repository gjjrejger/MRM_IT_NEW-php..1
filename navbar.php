<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Dashboard Navbar
 * Part 1
 * ==========================================================
 */

$currentUser = currentUser();

?>

<!-- ==========================================================
     TOP NAVBAR
=========================================================== -->

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top dashboard-navbar">

    <div class="container-fluid">

        <!-- Sidebar Toggle -->

        <button
            class="btn btn-light me-3"
            id="sidebarToggle">

            <i class="bi bi-list fs-4"></i>

        </button>

        <!-- Page Title -->

        <div class="d-flex align-items-center">

            <h4 class="mb-0 fw-bold">

                <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?>

            </h4>

        </div>

        <!-- Right Menu -->

        <div class="ms-auto d-flex align-items-center">

            <!-- Search -->

            <form class="d-none d-lg-flex me-4">

                <div class="input-group">

                    <span class="input-group-text bg-white">

                        <i class="bi bi-search"></i>

                    </span>

                   <input
                            type="text"
                            id="globalSearch"
                            class="form-control"
                            placeholder="Search products, users...">
                </div>

            </form>

            <!-- Notifications -->

            <div class="dropdown me-3">

                <button
                    class="btn btn-light position-relative"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-bell fs-5"></i>

                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                        3

                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <h6 class="dropdown-header">

                            Notifications

                        </h6>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-box-seam text-warning"></i>

                            Low Stock Alert

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-cart-check text-primary"></i>

                            Purchase Order Pending

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-check-circle text-success"></i>

                            Approval Completed

                        </a>

                    </li>

                </ul>

            </div>
                        <!-- Pending Approvals -->

            <div class="dropdown me-3">

                <button
                    class="btn btn-light position-relative"
                    data-bs-toggle="dropdown"
                    title="Pending Approvals">

                    <i class="bi bi-check2-square fs-5"></i>

                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">

                        5

                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <h6 class="dropdown-header">

                            Pending Approvals

                        </h6>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            Purchase Order #1025

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            Stock Adjustment #204

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            Invoice INV-1054

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item text-primary"

                           href="<?= APP_URL ?>/dashboard/approvals/approvals.php">

                            View All Approvals

                        </a>

                    </li>

                </ul>

            </div>

            <!-- Messages -->

            <div class="dropdown me-3">

                <button
                    class="btn btn-light position-relative"
                    data-bs-toggle="dropdown"
                    title="Messages">

                    <i class="bi bi-chat-dots fs-5"></i>

                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">

                        2

                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <h6 class="dropdown-header">

                            Messages

                        </h6>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            Finance approved today's invoices.

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            Warehouse stock has been updated.

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item text-primary" href="#">

                            View All Messages

                        </a>

                    </li>

                </ul>

            </div>

            <!-- Current Date & Time -->

            <div class="d-none d-xl-flex align-items-center me-4">

                <i class="bi bi-calendar3 me-2 text-primary"></i>

                <span id="currentDateTime" class="fw-semibold"></span>

            </div>

            <!-- Theme Toggle (Future Ready) -->

            <button
                class="btn btn-light me-3"
                id="themeToggle"
                title="Toggle Theme">

                <i class="bi bi-moon-stars"></i>

            </button>
                        <!-- User Profile -->

            <div class="dropdown">

                <button
                    class="btn btn-light d-flex align-items-center"
                    data-bs-toggle="dropdown">

                    <div class="me-2 text-end d-none d-md-block">

                        <strong>

                            <?= htmlspecialchars(fullName()); ?>

                        </strong>

                        <br>

                        <small class="text-muted">

                            <?= htmlspecialchars(userRole()); ?>

                        </small>

                    </div>

                    <div
                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                        style="width:42px;height:42px;">

                        <?= htmlspecialchars(userInitials()); ?>

                    </div>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li class="dropdown-header">

                        <strong>

                            <?= htmlspecialchars(fullName()); ?>

                        </strong>

                        <br>

                        <small>

                            <?= htmlspecialchars(userEmail()); ?>

                        </small>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item"
                           href="<?= APP_URL ?>/dashboard/profile.php">

                            <i class="bi bi-person-circle me-2"></i>

                            My Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item"
                           href="<?= APP_URL ?>/dashboard/system/system_settings.php">

                            <i class="bi bi-gear me-2"></i>

                            Settings

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item"
                           href="<?= APP_URL ?>/dashboard/approvals/approvals.php">

                            <i class="bi bi-check2-square me-2"></i>

                            My Approvals

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item text-danger"
                           href="<?= APP_URL ?>/public/logout.php"
                           onclick="return confirm('Are you sure you want to logout?');">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

<!-- ==========================================================
     NAVBAR SCRIPTS
=========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Sidebar Toggle
    |--------------------------------------------------------------------------
    */

    const sidebar = document.querySelector('.sidebar');
    const toggle = document.getElementById('sidebarToggle');

    if (toggle && sidebar) {

        toggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Live Date & Time
    |--------------------------------------------------------------------------
    */

    function updateClock() {

        const element = document.getElementById('currentDateTime');

        if (!element) return;

        const now = new Date();

        element.textContent = now.toLocaleString();

    }

    updateClock();

    setInterval(updateClock, 1000);

    /*
    |--------------------------------------------------------------------------
    | Theme Toggle Placeholder
    |--------------------------------------------------------------------------
    */

    const themeToggle = document.getElementById('themeToggle');

    if (themeToggle) {

        themeToggle.addEventListener('click', function () {

            alert('Dark Mode will be implemented in the final version.');

        });

    }

});
</script>
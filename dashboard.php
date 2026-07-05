<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Master Dashboard
 * File: dashboard/dashboard.php
 * ==========================================================
 */

// require_once '../app/config/bootstrap.php';
// requireLogin();

session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: ../login.php");
    exit;
}

$pageTitle = 'Dashboard';

/*
|--------------------------------------------------------------------------
| Demo Data
|--------------------------------------------------------------------------
|
| Replace these with database queries later.
|
*/

$totalProducts      = 1245;
$totalSuppliers     = 52;
$totalUsers         = 38;
$lowStockItems      = 14;
$pendingOrders      = 19;
$pendingApprovals   = 8;
$totalSalesToday    = 257850;
$totalPurchases     = 194300;

include 'partials/header.php';
include 'partials/sidebar.php';
include 'partials/navbar.php';

?>

<div class="content-wrapper">

<div class="container-fluid">

<!-- ==========================================================
     PAGE HEADER
=========================================================== -->

<div class="row mb-4">

    <div class="col-md-8">

        <h2 class="fw-bold">

            Welcome,

            <?= htmlspecialchars(fullName()); ?>

        </h2>

        <p class="text-muted">

            <?= date('l, d F Y'); ?>

        </p>

    </div>

    <div class="col-md-4 text-end">

        <span class="badge bg-success fs-6">

            <?= htmlspecialchars(userRole()); ?>

        </span>

    </div>

</div>

<!-- ==========================================================
     KPI CARDS
=========================================================== -->

<div class="row g-4">

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Products

                        </small>

                        <h2 data-counter="<?= $totalProducts; ?>">

                            0

                        </h2>

                    </div>

                    <i class="bi bi-box-seam fs-1 text-primary"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Suppliers

                        </small>

                        <h2 data-counter="<?= $totalSuppliers; ?>">

                            0

                        </h2>

                    </div>

                    <i class="bi bi-truck fs-1 text-success"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Users

                        </small>

                        <h2 data-counter="<?= $totalUsers; ?>">

                            0

                        </h2>

                    </div>

                    <i class="bi bi-people fs-1 text-warning"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">

                            Low Stock

                        </small>

                        <h2 data-counter="<?= $lowStockItems; ?>">

                            0

                        </h2>

                    </div>

                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<br>

<div class="row g-4">

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0 bg-light">

            <div class="card-body">

                <small class="text-muted">

                    Today's Sales

                </small>

                <h3>

                    KSh <?= number_format($totalSalesToday); ?>

                </h3>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0 bg-light">

            <div class="card-body">

                <small class="text-muted">

                    Purchases

                </small>

                <h3>

                    KSh <?= number_format($totalPurchases); ?>

                </h3>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0 bg-light">

            <div class="card-body">

                <small class="text-muted">

                    Pending Orders

                </small>

                <h3>

                    <?= $pendingOrders; ?>

                </h3>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="card shadow-sm border-0 bg-light">

            <div class="card-body">

                <small class="text-muted">

                    Pending Approvals

                </small>

                <h3>

                    <?= $pendingApprovals; ?>

                </h3>

            </div>

        </div>

    </div>

</div>
<!-- ==========================================================
     DASHBOARD ANALYTICS
=========================================================== -->

<div class="row mt-4">

    <!-- Sales Chart -->

    <div class="col-lg-8 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Monthly Sales Overview

                </h5>

            </div>

            <div class="card-body">

                <canvas id="salesChart" height="120"></canvas>

            </div>

        </div>

    </div>

    <!-- Inventory Distribution -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Inventory Distribution

                </h5>

            </div>

            <div class="card-body">

                <canvas id="inventoryChart"></canvas>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     LOW STOCK & RECENT PURCHASE ORDERS
=========================================================== -->

<div class="row">

    <!-- Low Stock -->

    <div class="col-lg-5">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-danger text-white">

                <h5 class="mb-0">

                    Low Stock Products

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                    <tr>

                        <th>Product</th>

                        <th>Stock</th>

                        <th>Reorder</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr data-stock="6" data-reorder="10">

                        <td>Corrugated Sheets</td>

                        <td>6</td>

                        <td>10</td>

                        <td>

                            <span class="badge bg-danger">

                                Critical

                            </span>

                        </td>

                    </tr>

                    <tr data-stock="9" data-reorder="10">

                        <td>Roof Nails</td>

                        <td>9</td>

                        <td>10</td>

                        <td>

                            <span class="badge bg-warning">

                                Low

                            </span>

                        </td>

                    </tr>

                    <tr data-stock="8" data-reorder="15">

                        <td>Galvanized Wire</td>

                        <td>8</td>

                        <td>15</td>

                        <td>

                            <span class="badge bg-danger">

                                Critical

                            </span>

                        </td>

                    </tr>

                    <tr data-stock="15" data-reorder="20">

                        <td>Paint Buckets</td>

                        <td>15</td>

                        <td>20</td>

                        <td>

                            <span class="badge bg-warning">

                                Low

                            </span>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Recent Purchase Orders -->

    <div class="col-lg-7">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Recent Purchase Orders

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-striped table-hover mb-0">

                    <thead>

                    <tr>

                        <th>PO No.</th>

                        <th>Supplier</th>

                        <th>Date</th>

                        <th>Amount</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>PO-1001</td>

                        <td>Steel Masters Ltd</td>

                        <td>26 Jun 2026</td>

                        <td>KSh 450,000</td>

                        <td>

                            <span class="badge bg-success">

                                Approved

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>PO-1002</td>

                        <td>Roofing Kenya Ltd</td>

                        <td>25 Jun 2026</td>

                        <td>KSh 280,000</td>

                        <td>

                            <span class="badge bg-warning">

                                Pending

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>PO-1003</td>

                        <td>ABC Hardware</td>

                        <td>25 Jun 2026</td>

                        <td>KSh 120,000</td>

                        <td>

                            <span class="badge bg-primary">

                                Processing

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>PO-1004</td>

                        <td>Prime Steel</td>

                        <td>24 Jun 2026</td>

                        <td>KSh 620,000</td>

                        <td>

                            <span class="badge bg-success">

                                Received

                            </span>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<!-- ==========================================================
     STOCK MOVEMENTS & APPROVALS
=========================================================== -->

<div class="row mt-4">

    <!-- Recent Stock Movements -->

    <div class="col-lg-7 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Recent Stock Movements

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                    <tr>

                        <th>Date</th>

                        <th>Product</th>

                        <th>Type</th>

                        <th>Quantity</th>

                        <th>User</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>26 Jun 2026</td>

                        <td>Corrugated Sheets</td>

                        <td>

                            <span class="badge bg-success">

                                Stock In

                            </span>

                        </td>

                        <td>+500</td>

                        <td>Warehouse Admin</td>

                    </tr>

                    <tr>

                        <td>26 Jun 2026</td>

                        <td>Roof Nails</td>

                        <td>

                            <span class="badge bg-danger">

                                Stock Out

                            </span>

                        </td>

                        <td>-120</td>

                        <td>Sales Officer</td>

                    </tr>

                    <tr>

                        <td>25 Jun 2026</td>

                        <td>Steel Pipes</td>

                        <td>

                            <span class="badge bg-warning text-dark">

                                Adjustment

                            </span>

                        </td>

                        <td>-15</td>

                        <td>Inventory Admin</td>

                    </tr>

                    <tr>

                        <td>25 Jun 2026</td>

                        <td>Wire Mesh</td>

                        <td>

                            <span class="badge bg-success">

                                Stock In

                            </span>

                        </td>

                        <td>+250</td>

                        <td>Warehouse Admin</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Pending Approvals -->

    <div class="col-lg-5 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    Pending Approval Queue

                </h5>

            </div>

            <div class="list-group list-group-flush">

                <a href="#"

                   class="list-group-item list-group-item-action">

                    Purchase Order #1025

                    <span class="badge bg-warning float-end">

                        Pending

                    </span>

                </a>

                <a href="#"

                   class="list-group-item list-group-item-action">

                    Stock Adjustment #203

                    <span class="badge bg-warning float-end">

                        Pending

                    </span>

                </a>

                <a href="#"

                   class="list-group-item list-group-item-action">

                    Sales Return #115

                    <span class="badge bg-warning float-end">

                        Pending

                    </span>

                </a>

                <a href="#"

                   class="list-group-item list-group-item-action">

                    Supplier Invoice #556

                    <span class="badge bg-warning float-end">

                        Pending

                    </span>

                </a>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     QUICK ACTIONS & RECENT ACTIVITY
=========================================================== -->

<div class="row">

    <!-- Quick Actions -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Quick Actions

                </h5>

            </div>

            <div class="card-body d-grid gap-2">

                <a href="<?= APP_URL ?>/dashboard/products/create.php"

                   class="btn btn-outline-primary">

                    <i class="bi bi-box-seam me-2"></i>

                    Add Product

                </a>

                <a href="<?= APP_URL ?>/dashboard/purchases/create.php"

                   class="btn btn-outline-success">

                    <i class="bi bi-cart-plus me-2"></i>

                    New Purchase Order

                </a>

                <a href="<?= APP_URL ?>/dashboard/sales/create.php"

                   class="btn btn-outline-warning">

                    <i class="bi bi-receipt me-2"></i>

                    New Sale

                </a>

                <a href="<?= APP_URL ?>/dashboard/reports"

                   class="btn btn-outline-secondary">

                    <i class="bi bi-file-earmark-bar-graph me-2"></i>

                    Generate Report

                </a>

            </div>

        </div>

    </div>

    <!-- Recent Activity -->

    <div class="col-lg-8 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Recent Activity

                </h5>

            </div>

            <div class="card-body">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item">

                        <strong>09:10 AM</strong>

                        Product "Roof Nails" updated by Inventory Admin.

                    </li>

                    <li class="list-group-item">

                        <strong>08:45 AM</strong>

                        Purchase Order PO-1025 approved.

                    </li>

                    <li class="list-group-item">

                        <strong>08:10 AM</strong>

                        New supplier registered.

                    </li>

                    <li class="list-group-item">

                        <strong>Yesterday</strong>

                        Warehouse stock count completed.

                    </li>

                    <li class="list-group-item">

                        <strong>Yesterday</strong>

                        Monthly inventory report generated.

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>
<!-- ==========================================================
     EXECUTIVE SUMMARY
=========================================================== -->

<div class="row mt-4">

    <!-- Warehouse Performance -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">

                    Warehouse Performance

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <thead>

                    <tr>

                        <th>Warehouse</th>

                        <th>Orders</th>

                        <th>Efficiency</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>Main Warehouse</td>

                        <td>542</td>

                        <td>

                            <div class="progress">

                                <div class="progress-bar bg-success"

                                     style="width:95%">

                                    95%

                                </div>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>Nairobi Depot</td>

                        <td>361</td>

                        <td>

                            <div class="progress">

                                <div class="progress-bar bg-primary"

                                     style="width:88%">

                                    88%

                                </div>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td>Mombasa Depot</td>

                        <td>298</td>

                        <td>

                            <div class="progress">

                                <div class="progress-bar bg-warning"

                                     style="width:76%">

                                    76%

                                </div>

                            </div>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Active Users -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-info text-white">

                <h5 class="mb-0">

                    Active Users

                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span>Users Online</span>

                    <strong class="text-success">18</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Logged In Today</span>

                    <strong>34</strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Pending Login Approvals</span>

                    <strong class="text-warning">2</strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>Locked Accounts</span>

                    <strong class="text-danger">1</strong>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     SALES PERFORMANCE
=========================================================== -->

<div class="row">

    <!-- Top Selling Products -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Top Selling Products

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                    <tr>

                        <th>Product</th>

                        <th>Units Sold</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>Corrugated Sheets</td>

                        <td>4,520</td>

                    </tr>

                    <tr>

                        <td>Roof Nails</td>

                        <td>3,950</td>

                    </tr>

                    <tr>

                        <td>Steel Pipes</td>

                        <td>3,240</td>

                    </tr>

                    <tr>

                        <td>Wire Mesh</td>

                        <td>2,910</td>

                    </tr>

                    <tr>

                        <td>Paint Buckets</td>

                        <td>2,125</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Sales vs Purchases -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    Sales vs Purchases

                </h5>

            </div>

            <div class="card-body">

                <canvas id="comparisonChart" height="180"></canvas>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     UPCOMING TASKS
=========================================================== -->

<div class="row">

    <div class="col-lg-12">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-secondary text-white">

                <h5 class="mb-0">

                    Upcoming Tasks & Reminders

                </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">

                        <div class="alert alert-warning">

                            Stock audit scheduled tomorrow.

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="alert alert-info">

                            Supplier contract renewal in 5 days.

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="alert alert-success">

                            Monthly inventory report due Friday.

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="alert alert-danger">

                            8 approvals awaiting action.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ==========================================================
     EXECUTIVE KPIs
=========================================================== -->

<div class="row mt-4">

    <!-- Financial Summary -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">

                    Financial Summary

                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span>Total Revenue</span>

                    <strong class="text-success">

                        KSh 18,450,000

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Total Purchases</span>

                    <strong>

                        KSh 11,250,000

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Gross Profit</span>

                    <strong class="text-primary">

                        KSh 7,200,000

                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>Outstanding Payments</span>

                    <strong class="text-danger">

                        KSh 820,000

                    </strong>

                </div>

            </div>

        </div>

    </div>

    <!-- Inventory Health -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Inventory Health

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <small>Healthy Stock</small>

                    <div class="progress">

                        <div class="progress-bar bg-success"

                             style="width:82%;">

                            82%

                        </div>

                    </div>

                </div>

                <div class="mb-3">

                    <small>Low Stock</small>

                    <div class="progress">

                        <div class="progress-bar bg-warning"

                             style="width:12%;">

                            12%

                        </div>

                    </div>

                </div>

                <div>

                    <small>Out of Stock</small>

                    <div class="progress">

                        <div class="progress-bar bg-danger"

                             style="width:6%;">

                            6%

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Supplier Performance -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    Supplier Performance

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-sm">

                    <thead>

                    <tr>

                        <th>Supplier</th>

                        <th>Rating</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>Steel Masters Ltd</td>

                        <td>★★★★★</td>

                    </tr>

                    <tr>

                        <td>Roofing Kenya</td>

                        <td>★★★★☆</td>

                    </tr>

                    <tr>

                        <td>ABC Hardware</td>

                        <td>★★★★☆</td>

                    </tr>

                    <tr>

                        <td>Prime Steel</td>

                        <td>★★★☆☆</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     BUSINESS PERFORMANCE
=========================================================== -->

<div class="row">

    <!-- Customer Activity -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-info text-white">

                <h5 class="mb-0">

                    Customer Activity

                </h5>

            </div>

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-4">

                        <h3 class="text-success">125</h3>

                        <small>New</small>

                    </div>

                    <div class="col-4">

                        <h3 class="text-primary">865</h3>

                        <small>Active</small>

                    </div>

                    <div class="col-4">

                        <h3 class="text-danger">21</h3>

                        <small>Inactive</small>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Branch Performance -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    Branch Performance

                </h5>

            </div>

            <div class="card-body">

                <canvas id="branchPerformanceChart"

                        height="180">

                </canvas>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     SYSTEM HEALTH
=========================================================== -->

<div class="row">

    <div class="col-lg-12">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-secondary text-white">

                <h5 class="mb-0">

                    System Health Monitor

                </h5>

            </div>

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-3">

                        <h4 class="text-success">

                            Online

                        </h4>

                        <small>Application</small>

                    </div>

                    <div class="col-md-3">

                        <h4 class="text-success">

                            Connected

                        </h4>

                        <small>Database</small>

                    </div>

                    <div class="col-md-3">

                        <h4 class="text-success">

                            Secure

                        </h4>

                        <small>Authentication</small>

                    </div>

                    <div class="col-md-3">

                        <h4 class="text-primary">

                            99.9%

                        </h4>

                        <small>System Uptime</small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ==========================================================
     ANNOUNCEMENTS & RECENT LOGINS
=========================================================== -->

<div class="row mt-4">

    <!-- Company Announcements -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Company Announcements

                </h5>

            </div>

            <div class="card-body">

                <div class="alert alert-primary">

                    📢 Monthly management meeting scheduled for next Monday.

                </div>

                <div class="alert alert-warning">

                    ⚠ Annual stock audit begins next week.

                </div>

                <div class="alert alert-success">

                    ✅ ERP Version <?= APP_VERSION; ?> successfully deployed.

                </div>

            </div>

        </div>

    </div>

    <!-- Recent Logins -->

    <div class="col-lg-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    Recent User Logins

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                    <tr>

                        <th>User</th>

                        <th>Role</th>

                        <th>Time</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>John Kariuki</td>

                        <td>Administrator</td>

                        <td>08:10 AM</td>

                    </tr>

                    <tr>

                        <td>Mary Wanjiku</td>

                        <td>Warehouse Manager</td>

                        <td>08:22 AM</td>

                    </tr>

                    <tr>

                        <td>Peter Mwangi</td>

                        <td>Sales Officer</td>

                        <td>08:35 AM</td>

                    </tr>

                    <tr>

                        <td>Grace Achieng</td>

                        <td>Procurement</td>

                        <td>08:50 AM</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     AUDIT LOG & FAVORITES
=========================================================== -->

<div class="row">

    <!-- Audit Log -->

    <div class="col-lg-8 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-secondary text-white">

                <h5 class="mb-0">

                    Recent Audit Log

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-striped table-hover mb-0">

                    <thead>

                    <tr>

                        <th>Date</th>

                        <th>User</th>

                        <th>Activity</th>

                    </tr>

                    </thead>

                    <tbody>

                    <tr>

                        <td>26 Jun 2026</td>

                        <td>Administrator</td>

                        <td>Created Product "Roof Tile A"</td>

                    </tr>

                    <tr>

                        <td>26 Jun 2026</td>

                        <td>Warehouse Manager</td>

                        <td>Updated Inventory</td>

                    </tr>

                    <tr>

                        <td>26 Jun 2026</td>

                        <td>Sales Officer</td>

                        <td>Generated Sales Invoice</td>

                    </tr>

                    <tr>

                        <td>25 Jun 2026</td>

                        <td>Procurement</td>

                        <td>Approved Purchase Order</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Favourite Shortcuts -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">

                    Favourite Shortcuts

                </h5>

            </div>

            <div class="card-body d-grid gap-2">

                <a href="<?= APP_URL ?>/dashboard/products"

                   class="btn btn-outline-primary">

                    Products

                </a>

                <a href="<?= APP_URL ?>/dashboard/inventory"

                   class="btn btn-outline-success">

                    Inventory

                </a>

                <a href="<?= APP_URL ?>/dashboard/sales"

                   class="btn btn-outline-warning">

                    Sales

                </a>

                <a href="<?= APP_URL ?>/dashboard/reports"

                   class="btn btn-outline-secondary">

                    Reports

                </a>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
     CHART INITIALIZATION
=========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    if (typeof Chart !== 'undefined') {

        // Sales Chart

        const salesCanvas = document.getElementById('salesChart');

        if (salesCanvas) {

            new Chart(salesCanvas, {

                type: 'line',

                data: {

                    labels: ['Jan','Feb','Mar','Apr','May','Jun'],

                    datasets: [{

                        label: 'Sales',

                        data: [120,190,300,250,420,500],

                        fill: false,

                        tension: 0.4

                    }]

                }

            });

        }

        // Inventory Chart

        const inventoryCanvas = document.getElementById('inventoryChart');

        if (inventoryCanvas) {

            new Chart(inventoryCanvas, {

                type: 'doughnut',

                data: {

                    labels: [

                        'Roofing',

                        'Steel',

                        'Accessories'

                    ],

                    datasets: [{

                        data: [45,35,20]

                    }]

                }

            });

        }

        // Sales vs Purchases

        const comparisonCanvas = document.getElementById('comparisonChart');

        if (comparisonCanvas) {

            new Chart(comparisonCanvas, {

                type: 'bar',

                data: {

                    labels: [

                        'Jan',

                        'Feb',

                        'Mar',

                        'Apr',

                        'May',

                        'Jun'

                    ],

                    datasets: [

                        {

                            label:'Sales',

                            data:[120,180,250,300,350,410]

                        },

                        {

                            label:'Purchases',

                            data:[90,150,200,210,260,300]

                        }

                    ]

                }

            });

        }

        // Branch Performance

        const branchCanvas = document.getElementById('branchPerformanceChart');

        if (branchCanvas) {

            new Chart(branchCanvas, {

                type:'radar',

                data:{

                    labels:[

                        'Nairobi',

                        'Mombasa',

                        'Kisumu',

                        'Nakuru',

                        'Eldoret'

                    ],

                    datasets:[{

                        label:'Performance',

                        data:[95,88,82,79,91]

                    }]

                }

            });

        }

    }

});

</script>

<?php include 'partials/footer.php'; ?>
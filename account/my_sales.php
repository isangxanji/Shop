<?php
// session_start() is already in MyAccount.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="sales-dashboard">
    
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-header">
                <i class="fa-solid fa-chart-simple"></i>
                <i class="fa-solid fa-arrow-up-right-from-square small-icon"></i>
            </div>
            <div class="stat-body">
                <strong>₱1399.92</strong>
                <span>Total Revenue</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <i class="fa-solid fa-bag-shopping"></i>
                <i class="fa-solid fa-arrow-up-right-from-square small-icon"></i>
            </div>
            <div class="stat-body">
                <strong>5</strong>
                <span>Orders</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <i class="fa-solid fa-users"></i>
                <i class="fa-solid fa-arrow-up-right-from-square small-icon"></i>
            </div>
            <div class="stat-body">
                <strong>5</strong>
                <span>Customers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <i class="fa-solid fa-arrow-up-right-from-square small-icon"></i>
            </div>
            <div class="stat-body">
                <strong>₱279.98</strong>
                <span>Avg. Order</span>
            </div>
        </div>
    </div>

    <div class="activity-container">
        <div class="activity-header">
            <h3><i class="fa-solid fa-user-group"></i> Buyer Activity</h3>
            <span class="activity-count">5 orders</span>
        </div>

        <div class="table-responsive">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="user-cell">
                            <div class="user-avatar">J</div>
                            <div class="user-info">
                                <p>Juan dela Cruz</p>
                                <small>juan@email.com</small>
                            </div>
                        </td>
                        <td>Classic Navy Blazer</td>
                        <td>1</td>
                        <td class="price-cell">₱129.99</td>
                        <td>May 3, 2025</td>
                        <td><span class="status-pill delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td class="user-cell">
                            <div class="user-avatar">M</div>
                            <div class="user-info">
                                <p>Maria Santos</p>
                                <small>maria@email.com</small>
                            </div>
                        </td>
                        <td>Premium Formal Suit</td>
                        <td>2</td>
                        <td class="price-cell">₱499.98</td>
                        <td>May 1, 2025</td>
                        <td><span class="status-pill shipped">Shipped</span></td>
                    </tr>
                    <tr>
                        <td class="user-cell">
                            <div class="user-avatar">P</div>
                            <div class="user-info">
                                <p>Pedro Reyes</p>
                                <small>pedro@email.com</small>
                            </div>
                        </td>
                        <td>Classic Navy Blazer</td>
                        <td>1</td>
                        <td class="price-cell">₱129.99</td>
                        <td>Apr 28, 2025</td>
                        <td><span class="status-pill delivered">Delivered</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$current_month_name = date('F'); // Get the current month name
?>

<div class="col-xl-3 col-xxl-5">
    <div class="card" style="box-shadow: none;">
        <div class="card-header border-0 pb-0">
            <div class="d-flex flex-column justify-content-center" style="width: 100%; text-align: center;">
                <h4 class="card-title mb-2">Top Customers</h4>
                <h4>(Month of <?php echo htmlspecialchars($current_month_name); ?>)</h4>
                <span class="fs-12">Customers with the most requested booking this month</span>
            </div>
        </div>
        <div class="card-body">    
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <div class="user-bx mt-2">
                        <img src="<?php echo htmlspecialchars($customer['profile']); ?>" alt="<?php echo htmlspecialchars($customer['customer_name']); ?>" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 10px;">
                        <div>
                            <h6 class="user-name"><?php echo htmlspecialchars($customer['customer_name']); ?></h6>
                            <span class="meta" style="font-weight: 600; color: blue;">Completed Requests: <?php echo $customer['completed_requests'] ?: 0; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center">
                    <p>No completed requests this month.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

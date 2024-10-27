<?php
$current_month_name = date('F'); // Get the current month name
?>

<div class="col-xl-3 col-xxl-7">
    <div class="card" style="box-shadow: none;">
        <div class="card-header border-0 pb-0">
            <div class="d-flex flex-column justify-content-center" style="width: 100%; text-align: center;">
                <h4 class="card-title mb-2">Top Employee</h4>
								<h4>(Month of <?php echo htmlspecialchars($current_month_name); ?>)</h4>
                <span class="fs-12">Employees with the most completed bookings this month</span>
            </div>
        </div>
        <div class="card-body">    
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $employee): ?>
                    <div class="user-bx mt-2">
                        <img src="<?php echo htmlspecialchars($employee['profile']); ?>" alt="<?php echo htmlspecialchars($employee['full_name']); ?>" class="rounded-circle" style="width: 50px; height: 50px;">
                        <div>
                            <h6 class="user-name"><?php echo htmlspecialchars($employee['full_name']); ?></h6>
                            <span class="meta" style="font-weight: 600; color: blue;">Completed Bookings: <?php echo $employee['completed_bookings'] ?: 0; ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center">
                    <p>No bookings completed this month.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

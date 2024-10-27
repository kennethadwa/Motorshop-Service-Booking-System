<div class="col-xl-6 col-xxl-7">
    <div class="card" style="box-shadow: none; max-height: 650px; overflow: hidden;">
        <div class="card-header d-flex flex-wrap border-0 pb-0">
            <div class="me-auto mb-sm-0 mb-3">
                <h4 class="card-title mb-2">Transaction Overview</h4>
                <span class="fs-12">Lorem ipsum dolor sit amet, consectetur</span>
            </div>
            <a href="javascript:void(0)" class="btn btn-rounded btn-md btn-primary me-3 me-3" onclick="exportToPDF()">
                <i class="las la-download scale5 me-3"></i>Download Report
            </a>
        </div>
        <div class="card-body pb-2" style="max-height: 550px; overflow-y: auto;">
            <div>
                <canvas id="lineChart" style="height: 450px; width: 100%;"></canvas>
            </div>
            <div class="mt-3">
                <h5>Total Deposit: ₱<?php echo number_format($total_deposit, 2); ?></h5>

                <?php
                // Assuming the following variables are already defined
                // $previous_month_total = 0; // This should come from your database or logic
                // $current_month_total = ... // Current month total deposits

                // Calculate percentage increase for deposits
                $percentage_increase = 0;
                if ($previous_month_total === 0 && $current_month_total > 0) {
                    $percentage_increase = 100; // If previous month was 0 and current is greater than 0, set to 100%
                } elseif ($previous_month_total > 0) {
                    $percentage_increase = (($current_month_total - $previous_month_total) / $previous_month_total) * 100;
                }
                ?>
                <h5>Percentage Increase in Deposits: <?php echo number_format($percentage_increase, 2); ?>%</h5>

                <?php
                // Assuming similar logic for completed bookings
                $previous_month_bookings = 0; // This should come from your database or logic
                $current_month_bookings = 75; // Example value for current month bookings

                $booking_percentage_increase = 0;
                if ($previous_month_bookings === 0 && $current_month_bookings > 0) {
                    $booking_percentage_increase = 100; // If previous month was 0 and current is greater than 0, set to 100%
                } elseif ($previous_month_bookings > 0) {
                    $booking_percentage_increase = (($current_month_bookings - $previous_month_bookings) / $previous_month_bookings) * 100;
                }
                ?>
                <h5>Percentage Increase in Completed Bookings: <?php echo number_format($booking_percentage_increase, 2); ?>%</h5>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('lineChart').getContext('2d');
        
        // Data from PHP for previous and current month deposit amounts
        var labels = [<?php echo json_encode($previous_month_name); ?>, <?php echo json_encode($current_month_name); ?>];
        var deposits = [<?php echo json_encode($previous_month_total ?? 0); ?>, <?php echo json_encode($current_month_total ?? 0); ?>];

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Deposit Amount (₱)',
                    data: deposits,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₱)'
                        }
                    }
                }
            }
        });
    });

    async function exportToPDF() {
    const canvas = document.getElementById('lineChart');
    const chartImage = await html2canvas(canvas, { backgroundColor: '#fff' });
    const imgData = chartImage.toDataURL('image/png');

    // Retrieve data from PHP (assumed to be accessible within script)
    const labels = <?php echo json_encode([$previous_month_name, $current_month_name]); ?>;
    const deposits = <?php echo json_encode([$previous_month_total ?? 0, $current_month_total ?? 0]); ?>;
    const totalDeposit = <?php echo json_encode(number_format($total_deposit, 2)); ?>;
    const percentageIncrease = <?php echo json_encode(number_format($percentage_increase, 2)); ?>;
    const bookingPercentageIncrease = <?php echo json_encode(number_format($booking_percentage_increase, 2)); ?>;

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    pdf.addImage(imgData, 'PNG', 10, 10, 190, 100);

    pdf.setFontSize(12);
    pdf.text(`Total Deposit: ₱${totalDeposit}`, 10, 120);
    pdf.text(`Percentage Increase in Deposits: ${percentageIncrease}%`, 10, 130);
    pdf.text(`Percentage Increase in Completed Bookings: ${bookingPercentageIncrease}%`, 10, 140);

    // Add chart data labels and values below the main data
    pdf.setFontSize(10);
    pdf.text("Deposit Overview", 10, 150);
    labels.forEach((label, index) => {
        pdf.text(`${label}: ₱${parseFloat(deposits[index]).toLocaleString()}`, 10, 160 + index * 10);
    });

    // Convert the PDF to Blob for sending and saving
    const pdfOutput = pdf.output('blob');

    const formData = new FormData();
    formData.append('file', pdfOutput, 'Transaction_Report.pdf');

    // Make AJAX request to send the PDF (optional)
    try {
        const response = await fetch('send_pdf.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.text();
        console.log(result); // Log the server response for debugging
        alert(result); // Display the server response to the user
    } catch (error) {
        console.error('Error sending PDF:', error);
        alert('Error sending PDF. Please try again.');
    }

    // Automatically download the PDF
    pdf.save('Transaction_Report.pdf');
}


</script>

<?php
// Get current and previous month names
$current_month_name = date("F") . "(Current Month)"; // Current month name
$previous_month_name = date("F", strtotime("-1 month")) . "(Previous Month)"; // Previous month name

// Your existing query and calculation code here
?>

<div class="col-xl-6 col-xxl-7">
    <div class="card" style="box-shadow: none; max-height: 650px; overflow: hidden;">
        <div class="card-header d-flex flex-wrap border-0 pb-0">
            <div class="me-auto mb-sm-0 mb-3">
                <h4 class="card-title mb-2">Transaction Overview</h4>
                <span class="fs-12">Comparison of Monthly Bookings</span>
            </div>
            <a href="javascript:void(0)" class="btn btn-rounded btn-md btn-primary me-3 me-3" onclick="exportToPDFs()">
                <i class="las la-download scale5 me-3"></i>Download Report
            </a>
        </div>
        <div class="card-body pb-2" style="max-height: 550px; overflow-y: auto;">
            <div>
                <canvas id="barChart" style="height: 450px; width: 100%;"></canvas>
            </div>
            <div class="mt-3">
                <h5>Total Bookings Change: <?php echo number_format($percentage_change, 2); ?>%</h5>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['<?php echo $previous_month_name; ?>', '<?php echo $current_month_name; ?>'],
                datasets: [{
                    label: 'Total Bookings',
                    data: [<?php echo $previous_month_total; ?>, <?php echo $current_month_total; ?>],
                    backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(75, 192, 192, 0.6)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Bookings'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    });


    async function exportToPDFs() {
        const canvas = document.getElementById('barChart');
        const chartImage = await html2canvas(canvas, { backgroundColor: '#fff' });
        const imgData = chartImage.toDataURL('image/png');

        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.addImage(imgData, 'PNG', 10, 10, 190, 100);

        // PDF content specific to card9.php
        const totalBookingsChange = '<?php echo number_format($percentage_change, 2); ?>%';
        const currentMonth = '<?php echo $current_month_name; ?>';
        const previousMonth = '<?php echo $previous_month_name; ?>';
        const previousMonthTotal = '<?php echo number_format($previous_month_total, 0); ?>';
        const currentMonthTotal = '<?php echo number_format($current_month_total, 0); ?>';

        pdf.setFontSize(12);
        pdf.text("Transaction Overview", 10, 120);
        pdf.text(`Comparison of Monthly Bookings`, 10, 130);
        pdf.text(`${previousMonth}: Total Bookings ${previousMonthTotal}`, 10, 140);
        pdf.text(`${currentMonth}: Total Bookings ${currentMonthTotal}`, 10, 150);
        pdf.text(`Total Bookings Change: ${totalBookingsChange}`, 10, 160);

        // Automatically download the PDF
        pdf.save('Transaction_Report_Card9.pdf');
    }

    document.querySelector('.btn-primary').addEventListener('click', exportToPDF);
</script>

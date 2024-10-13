<?php
// Set the timezone to Manila, Philippines
date_default_timezone_set('Asia/Manila');

// Create a DateTime object for the current month
$currentDate = new DateTime();
$firstDayOfMonth = new DateTime($currentDate->format('Y-m-01'));
$lastDayOfMonth = new DateTime($currentDate->format('Y-m-t'));

// Create an array of days of the week
$daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// Get the number of days in the month
$daysInMonth = $lastDayOfMonth->format('d');

// Get the day of the week for the first day of the month
$startDay = (int) $firstDayOfMonth->format('w');

// Get the current day
$currentDay = (int) $currentDate->format('j'); // Day of the month without leading zeros

// Define an array of holiday dates (in 'j' format for day of the month)
$holidays = [10, 25, 30, 31]; // Example: 10th and 25th of the current month

// Create a calendar array
$calendar = [];
$dayCount = 1;

// Fill the calendar array with empty slots for days before the start of the month
for ($i = 0; $i < $startDay; $i++) {
    $calendar[0][] = '';
}

// Fill the calendar array with the days of the month
for ($dayCount; $dayCount <= $daysInMonth; $dayCount++) {
    $weekIndex = (int)(($startDay + $dayCount - 1) / 7);
    $calendar[$weekIndex][] = $dayCount;
}

// Fill the remaining slots of the last week with empty strings
while (count($calendar[count($calendar) - 1]) < 7) {
    $calendar[count($calendar) - 1][] = '';
}
?>

<div class="col-xl-6 col-xxl-6 col-sm-12">
    <div class="card invoice-card" style="box-shadow: none; height: auto; display: flex; flex-direction: column; box-shadow: 2px 2px 2px black; background-image: linear-gradient(to bottom, #030637, #3C0753);">
        <div class="card-body flex-grow-1" style="padding: 25px;"> <!-- Reduced padding for height -->
            <h5 class="text-white text-center">Calendar - <?php echo $currentDate->format('F Y'); ?></h5>
            <div class="calendar" id="calendar">
                <table class="table text-white table-bordered">
                    <thead>
                        <tr>
                            <?php foreach ($daysOfWeek as $day): ?>
                                <th><?php echo $day; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($calendar as $week): ?>
                            <tr>
                                <?php foreach ($week as $day): ?>
                                    <td class="text-center 
                                        <?php
                                        if ($day == $currentDay) {
                                            echo 'current-day';
                                        } elseif (in_array($day, $holidays)) {
                                            echo 'holiday';
                                        }
                                        ?>" 
                                        data-day="<?php echo $day; ?>">
                                        <?php echo $day ? $day : ''; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center" style="margin: 0; padding: 0;">
            <!-- Legend -->
            <div class="legend">
                <span class="legend-box current-day-box"></span> Current Day
                <span class="legend-box holiday-box"></span> Holiday
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional styles for responsiveness */
    .calendar {
        overflow-x: auto;
        flex-grow: 1; /* Allow calendar to take available space */
    }

    /* Style adjustments for table */
    .table {
        width: 100%;
        table-layout: fixed; /* Ensures equal column width */
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle; /* Center content vertically */
        padding: 3px; /* Padding for cells */
    }

    /* Highlight the current day */
    .current-day {
        background-color: #28a745 !important; /* Green background for current day */
        color: white !important;
        font-weight: bold;
    }

    /* Highlight holidays */
    .holiday {
        background-color: #dc3545 !important; /* Red background for holidays */
        color: white !important;
        font-weight: bold;
    }

    /* Legend styles */
    .legend {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px; /* Adjusted gap between legend items */
        color: white;
        margin-bottom: 10px;
    }

    .legend-box {
        width: 15px;
        height: 15px;
        display: inline-block;
        margin-right: 5px;
        border: 1px solid #ccc;
    }

    .current-day-box {
        background-color: #28a745;
    }

    .holiday-box {
        background-color: #dc3545;
    }
</style>

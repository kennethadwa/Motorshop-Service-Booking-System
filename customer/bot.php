<?php
session_start();

include('../connection.php');
require_once '../config.php';
require_once '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['access_token'])) {
        $client->setAccessToken($token['access_token']);

        // Get profile info
        $google_oauth = new \Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $userinfo = [
            'email' => $google_account_info['email'],
            'first_name' => $google_account_info['givenName'],
            'last_name' => $google_account_info['familyName'],
            'sex' => $google_account_info['gender'],
            'token' => $google_account_info['id'],
        ];

        // Check if Google account already exists in the database
        $sql = "SELECT * FROM customers WHERE token = '{$userinfo['token']}'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Existing user
            $userinfo = mysqli_fetch_assoc($result);
            $_SESSION['token'] = $userinfo['token']; // Use token for Google SSO users
            $_SESSION['customer_id'] = $userinfo['customer_id'];
            $_SESSION['account_type'] = $userinfo['account_type']; // Set account type
        } else {
            // New user, insert into the database
            $sql = "INSERT INTO customers (first_name, last_name, sex, email, account_type, token) 
                    VALUES ('{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['sex']}', '{$userinfo['email']}', 2, '{$userinfo['token']}')";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error creating account: " . mysqli_error($conn));
            }

            // Retrieve the customer ID of the newly inserted user
            $stmt = $conn->prepare("SELECT customer_id, account_type FROM customers WHERE token = ?");
            $stmt->bind_param("s", $userinfo['token']);
            $stmt->execute();
            $stmt->bind_result($customer_id, $account_type);
            $stmt->fetch();
            $_SESSION['token'] = $userinfo['token']; // Use token for Google SSO users
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['account_type'] = $account_type; // Set account type
            $stmt->close();

            echo "<script>alert('Account Successfully Created!');</script>";
        }

        // Redirect after login or account creation
        header("Location: packages.php"); // Redirect to your main page
        exit();
    } else {
        echo "Authentication failed. Please try again.";
        die();
    }
} else {
    // Check if user is already logged in using other methods
    if (isset($_SESSION['customer_id'])) {
        $sql = "SELECT * FROM customers WHERE customer_id = '{$_SESSION['customer_id']}'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $userinfo = mysqli_fetch_assoc($result);
            $_SESSION['account_type'] = $userinfo['account_type'];
        }
    }
}

// Redirect if account_type is not set to 2
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: ../login-register.php"); // Redirect to login page if not allowed
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Packages</title>
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="chat.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #17153B;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .wrapper {
            width: 100%;
            max-width: 500px;
            height: 100%;
            background-color: white;
            color: black;
            border: 1px solid black;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
        }

        .wrapper .title {
            background: black;
            color: white;
            font-weight: 500;
            line-height: 60px;
            text-align: center;
            border-bottom: 1px solid black;
            border-radius: 5px 5px 0 0;
        }

        .wrapper .form {
            flex: 1;
            padding: 20px 15px;
            overflow-y: auto;
        }

        .wrapper .form .user-inbox {
             display: flex;
             justify-content: flex-end; /* Aligns user messages to the right */
             margin: 13px 0;
         }

         .form .user-inbox .msg-header p {
             color: white;
             background: #007bff; /* Change to a blue color or any color you prefer for user messages */
             border-radius: 10px;
             padding: 8px 10px;
             font-size: 0.9rem;
             word-break: break-word;
             text-align: right; /* Text aligns to the right */
         }

        .wrapper .typing-field {
            display: flex;
            height: 60px;
            align-items: center;
            background-color: #efefef;
            border-top: 1px solid #d9d9d9;
            padding: 10px;
        }

        .wrapper .typing-field .input-data {
            flex: 1;
            position: relative;
            height: 40px;
        }

        .wrapper .typing-field .input-data input {
            width: 100%;
            height: 100%;
            padding: 0 80px 0 15px;
            color: white;
            background: black;
            border: 1px solid transparent;
            border-radius: 3px;
            font-size: 15px;
            outline: none;
        }

        .wrapper .typing-field .input-data button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            height: 30px;
            width: 65px;
            background: blue;
            color: white;
            border: 1px solid blue;
            border-radius: 3px;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
        }

        .wrapper .typing-field .input-data input:valid ~ button {
            opacity: 1;
            pointer-events: auto;
        }

        .form .user-inbox .msg-header p, 
        .form .bot-inbox .msg-header p {
            color: white;
            background: black;
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 0.9rem;
            word-break: break-word;
        }

        .wrapper .form .inbox {
            width: 100%;
            display: flex;
            align-items: baseline;
            margin: 10px 0;
        }

        .wrapper .form .inbox .icon {
            height: 40px;
            width: 40px;
            text-align: center;
            background-color: black;
            color: white;
            line-height: 40px;
            font-size: 1.3rem;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="title"  style="display: flex; padding: 10px;">
        <img src="../images/sairom.png" alt="" style="width: 60px; height: 60px; border-radius: 50%;">
        &nbsp;&nbsp;
        Sairom Motor Shop
    </div>

    <div class="form">
        <div class="bot-inbox inbox">
            <div><img src="../images/sairom.png" alt="" style="width: 60px; height: 60px; border-radius: 50%;"></div>
            &nbsp;
            <div class="msg-header">
                <p>Hello there, how can I help you?</p>
            </div>
        </div>
    </div>
    <div class="typing-field">
        <div class="input-data">
            <input type="text" id="data" placeholder="Do you have any questions?" required>
            <button id="send-btn">Send</button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/chart.js/Chart.bundle.min.js"></script>
<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
<script src="vendor/apexchart/apexchart.js"></script>
<script src="vendor/nouislider/nouislider.min.js"></script>
<script src="vendor/wnumb/wNumb.js"></script>
<script src="js/dashboard/dashboard-1.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/dlabnav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>

<script>
  $(document).ready(function(){
    $("#send-btn").on("click", function(){
         let value = $("#data").val().trim();
         if (value) {
             let msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + value + '</p></div></div>';
             $(".form").append(msg);
             $("#data").val('');
             $.ajax({
                url: 'message.php',
                type: 'POST',
                data: { text: value },
                success: function(result){
                  let reply = '<div class="bot-inbox inbox"><div><img src="../images/sairom.png" alt="" style="width: 60px; height: 60px; border-radius: 50%;"></div> &nbsp; <div class="msg-header"><p>' + result + '</p></div></div>';
                  $(".form").append(reply);
                  $(".form").scrollTop($(".form")[0].scrollHeight);
                }
             });
         }
    });
  });
</script>
</body>
</html>

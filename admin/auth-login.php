<?php
session_start();
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){

        $secretKey = '6LddpWYqAAAAAOAe7s3Sfry8xRZhTFur38Ienozm';

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='. $secretKey.'&response='.$_POST['g-recaptcha-response']);
        $response = json_decode($verifyResponse);

        if($response -> success){

                    $query = "SELECT admin_id, employee_id, customer_id, first_name, last_name, account_type, password FROM (
                SELECT admin_id, NULL AS employee_id, NULL AS customer_id, email, first_name, last_name, account_type, password FROM admin
                UNION ALL
                SELECT NULL AS admin_id, employee_id, NULL AS customer_id, email, first_name, last_name, account_type, password FROM employees
                UNION ALL
                SELECT NULL AS admin_id, NULL AS employee_id, customer_id, email, first_name, last_name, account_type, password FROM customers
              ) AS users
              WHERE email = ? LIMIT 1";

    // Prepare the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

    
        if (password_verify($password, $hashed_password)) {
            $account_type = $row['account_type'];

   
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $row['first_name']; 
            $_SESSION['last_name'] = $row['last_name']; 
            $_SESSION['account_type'] = $account_type;

            
            if ($account_type == 0) { 
                $_SESSION['admin_id'] = $row['admin_id']; 
            }

            switch ($account_type) {
                case 0: 
                    header("Location: index"); 
                    break;
            }
            exit();
        } else {
           
            echo "<script>alert('Invalid password!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        
        echo "<script>alert('No user found with this email!'); window.location.href='login.php';</script>";
        exit();
    }

        } else {
            echo '<script>alert("Failed to verify");</script>';
            header("Location: login");
        }

    } else {

        echo '<script>alert("Failed to verify");</script>';
        header("Location: login");
    }

    
}
?>

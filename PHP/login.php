<?php
    require('connection.php');
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $accesskey = $_POST['Accesskey'];

        $stmt = $conn->prepare("SELECT * FROM adminaccesskey WHERE Accesskey = ?");
        $stmt->bind_param("s", $accesskey);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['authenticated'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = true;
            header("Location: login.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Inventory</title>
    <link rel="stylesheet" href="../CSS/adlogin.css">
    <link rel="icon" href="../IMAGES/BLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script defer src="../JS/loginerror.js"></script>
    <script defer src="../JS/logoutmessage.js"></script>
</head>
<body>
    <?php 
        if(isset($_SESSION['error_message'])) {
    ?>
            <div id="UpdateMessage">
                <div id="UpdateMessageChild">
                    <span id="logo"><i class="fas fa-times"></i></span>
                    <span id="main-text">
                        <h3>Invalid Access Key</h3>
                        <h6>Please enter a valid access key to proceed with authentication.</h6>
                    </span>
                </div>
            </div>
    <?php
            unset($_SESSION['error_message']);
        }

        if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    ?>  
            <div id="LogoutMessage">
                <div id="LogoutMessageChild">
                    <p>Logged Out!</p>
                </div>
            </div>
    <?php 
        }
    ?>
    <main class="Login-MainContent">
        <div class="login-header">
            <h1>PKII</h1>
            <h2>License Inventory System</h2>
        </div>
        <div class="access-inputP">
            <form action="" method="post">
                <div class="access-input">
                    <label>Accesskey<span>*</span></label>
                    <input type="password" name="Accesskey" placeholder="Enter Accesskey" required>
                </div>
                <div class="btnsubmit">
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>
    </main>
</body>
</html>
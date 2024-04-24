<?php
    require('connection.php');

    session_start();

    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fullName = $_POST['FName'];
        $address = $_POST['Address'];
        $licenseNumber = $_POST['LicNo'];
        $expirationDate = $_POST['EDate'];

        $sql = "INSERT INTO driversinventory (FName, Address, LicNo, ExpDate) VALUES ('$fullName', '$address', '$licenseNumber', '$expirationDate')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMAGES/BLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/stylessss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../JS/modal.js"></script>
    <script defer src="../JS/search.js"></script>
    <script defer src="../JS/editmodals.js"></script>
    <script defer src="../JS/deletemodals.js"></script>
    <script defer src="../JS/addsuccess.js"></script>
    <title>License Inventory</title>
    <style>
        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-100%);
            }
            100% {
                opacity: 1;
                transform: translateY(0%);
            }
        }
        #UpdateMessage {
            position: absolute;
            top: 25px;
            left: 37%;
            transform: translateX(-50%);
            animation: slideInFromTop 0.5s ease-out forwards;
            z-index: 9999;
        }
        #UpdateMessageChild {
            width: 500px;
            height: 70px;
            border: 3.5px solid #00c04b;
            background-color: white;
            display: flex;
            align-items: center;
            border-radius: 10px;
            gap: 4%;
            padding: 0 4%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        @media (max-width: 844px) {            
            #UpdateMessage {
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%) !important;
                animation: slideInFromTop 0.5s ease-in-out !important;
            }
            
            #UpdateMessageChild {
                width: 300px !important;
                height: 60px !important;
            }
            
            #logo {
                font-size: 25px !important;
            }
            
            #main-text h3 {
                font-size: 16px !important;
            }
            
            #main-text h6 {
                font-size: 10px !important;
            }
        }
    </style>
</head>
<body>
    <script>
        setTimeout(function() {
            var updateMessage = document.getElementById("UpdateMessage");
            if (updateMessage) {
                updateMessage.parentNode.removeChild(updateMessage);
            }
        }, 3000);
    </script>
    <?php
        if (isset($_SESSION['success_message'])) {
            ?>
                <div id="UpdateMessage">
                    <div id="UpdateMessageChild">
                        <span id="logo" style="color: #00c04b; font-size: 35px;"><i class="fas fa-check"></i></span>
                        <span id="main-text">
                            <h3 style="color: #00c04b; font-weight: 600;">Added Successfully</h3>
                            <h6 style="color: gray; font-weight: 600;">Driver's record has been added successfully.</h6>
                        </span>
                    </div>
                </div>
            <?php
            unset($_SESSION['success_message']);
        }
        
        if (isset($_SESSION['update_success_message'])) {
            ?>
                <div id="UpdateMessage">
                    <div id="UpdateMessageChild">
                        <span id="logo" style="color: #00c04b; font-size: 35px;"><i class="fas fa-check"></i></span>
                        <span id="main-text">
                            <h3 style="color: #00c04b; font-weight: 600;">Edited Successfully</h3>
                            <h6 style="color: gray; font-weight: 600;">Records has been updated successfully.</h6>
                        </span>
                    </div>
                </div>
            <?php
            unset($_SESSION['update_success_message']);
        }
    ?>
    <main>
        <div class="header">
            <h1>Inventory System</h1>
            <p class="FP">Driver's Licences of Philkoei International Inc.</p>
            <p class="SP">Driver's Licences of PKII</p>
        </div>
        <div class="lg">
            <a href="logout.php" class="lgout">Logout</a>
        </div>
        <div class="sub-header">
            <div class="search-div">
                <form>
                <input class="searchbar" type="search" id="searchInput" name="search" autocomplete="off" placeholder="Search..." onkeyup="searchTable()">
                <button type="submit">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20" height="20" viewBox="0 0 122.879 119.799" enable-background="new 0 0 122.879 119.799" xml:space="preserve">
                        <g><path fill="white" d="M49.988,0h0.016v0.007C63.803,0.011,76.298,5.608,85.34,14.652c9.027,9.031,14.619,21.515,14.628,35.303h0.007v0.033v0.04 h-0.007c-0.005,5.557-0.917,10.905-2.594,15.892c-0.281,0.837-0.575,1.641-0.877,2.409v0.007c-1.446,3.66-3.315,7.12-5.547,10.307 l29.082,26.139l0.018,0.016l0.157,0.146l0.011,0.011c1.642,1.563,2.536,3.656,2.649,5.78c0.11,2.1-0.543,4.248-1.979,5.971 l-0.011,0.016l-0.175,0.203l-0.035,0.035l-0.146,0.16l-0.016,0.021c-1.565,1.642-3.654,2.534-5.78,2.646 c-2.097,0.111-4.247-0.54-5.971-1.978l-0.015-0.011l-0.204-0.175l-0.029-0.024L78.761,90.865c-0.88,0.62-1.778,1.209-2.687,1.765 c-1.233,0.755-2.51,1.466-3.813,2.115c-6.699,3.342-14.269,5.222-22.272,5.222v0.007h-0.016v-0.007 c-13.799-0.004-26.296-5.601-35.338-14.645C5.605,76.291,0.016,63.805,0.007,50.021H0v-0.033v-0.016h0.007 c0.004-13.799,5.601-26.296,14.645-35.338C23.683,5.608,36.167,0.016,49.955,0.007V0H49.988L49.988,0z M50.004,11.21v0.007h-0.016 h-0.033V11.21c-10.686,0.007-20.372,4.35-27.384,11.359C15.56,29.578,11.213,39.274,11.21,49.973h0.007v0.016v0.033H11.21 c0.007,10.686,4.347,20.367,11.359,27.381c7.009,7.012,16.705,11.359,27.403,11.361v-0.007h0.016h0.033v0.007 c10.686-0.007,20.368-4.348,27.382-11.359c7.011-7.009,11.358-16.702,11.36-27.4h-0.006v-0.016v-0.033h0.006 c-0.006-10.686-4.35-20.372-11.358-27.384C70.396,15.56,60.703,11.213,50.004,11.21L50.004,11.21z"/></g>
                    </svg>
                </button>
                </form>
            </div>

            <input class="addbtn" id="btn" type="button" value="Add New Driver">

            <dialog id="modal">
                <div class="close-mod">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="closeBTN" onclick="document.getElementById('modal').close();" style="cursor: pointer;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
                <div class="M-header">
                    <h1>Add New Driver</h1>
                </div>
                <form action="" method="post" class="addform">
                <div class="MM-body">
                    <div class="MMsub-body">
                        <h1>Driver's Information</h1>
                        <div class="input-body">
                            <div class="Fname-P">
                                <p>Full Name<span>*</span></p>
                                <input type="text" name="FName" placeholder="Enter Full Name" required autocomplete="off">
                            </div>
                            <div class="Address-P">
                                <p>Address<span>*</span></p>
                                <input type="text" name="Address" placeholder="Enter Address" required autocomplete="off">
                            </div>
                            <div class="LicNo-P">
                                <p>Licence Number<span>*</span></p>
                                <input type="text" name="LicNo" placeholder="Enter Licence Number" required autocomplete="off">
                            </div>
                            <div class="EDate-P">
                                <p>Exipiration Date<span>*</span></p>
                                <input type="date" name="EDate" title="Please enter a valid date in the format MM/DD/YYYY" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Btn-body">
                    <input id="M-btn" type="submit" value="Add Driver">
                </div>
                </form>
            </dialog>

        </div>

        <div class="lic-update">

            <div class="lics-div">
                <?php include('license_counts.php'); ?>
                <div class="active-lic">
                    <h1><?php echo $activeCount; ?></h1>
                    <p>Active Licences</p>
                </div>
                <div class="expiry-lic">
                    <h1><?php echo $expiryCount; ?></h1>
                    <p>Expiry Licences</p>
                </div>
            </div>

            <div class="expiry-list">
                <h1>Drivers Licences Expiry Lists</h1>
                <div class="e-list">
                <table width="100%" id="myTable2">
                        <thead>
                            <tr>
                                <th>Driver's Name</th>
                                <th>Expire Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <script>
                            function fetchRecords() {
                                jQuery.ajax({
                                    url: 'tablexpdata.php',
                                    type: 'GET',
                                    success: function(response) {
                                        jQuery('#myTable2').find('tbody').html(response);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            }

                            jQuery(document).ready(function() {
                                fetchRecords();

                                setInterval(fetchRecords, 1000);
                            });
                        </script>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="main-table">
            <table width="100%" id="myTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>License Number</th>
                    <th>Expiration Date</th>
                    <th>Days Before Expiring</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require('connection.php');

                $sql = "SELECT * FROM driversinventory ORDER BY FName ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["D_id"];
                        $fullName = $row["FName"];
                        $expirationTimestamp = strtotime($row["ExpDate"]);
                        $currentTimestamp = time();
                        $daysLeft = floor(($expirationTimestamp - $currentTimestamp) / (60 * 60 * 24));
                        if (date('Y-m-d', $currentTimestamp) == date('Y-m-d', $expirationTimestamp)) {
                            $expirationStatus = "Expiring today";
                        } elseif ($daysLeft < 0) {
                            $expirationStatus = "Already Expired";
                        } elseif (date('Y-m-d', strtotime('+1 day', $currentTimestamp)) == date('Y-m-d', $expirationTimestamp)) {
                            $expirationStatus = "Expiring Tomorrow";
                        } else {
                            $expirationStatus = $daysLeft . " Days Left";
                        }        
                    ?>
                        <tr>
                        <td id="name_<?php echo $id; ?>"><?php echo $row["FName"]; ?></td>
                        <td id="address_<?php echo $id; ?>"><?php echo $row["Address"]; ?></td>
                        <td id="licno_<?php echo $id; ?>"><?php echo $row["LicNo"]; ?></td>
                        <td id="expDate_<?php echo $id; ?>"><?php echo date('F d, Y', strtotime($row["ExpDate"])); ?></td>
                            <td><?php echo $expirationStatus; ?></td>
                            <td width="15%">
                            <div class="ED-container">
                                <a class="edit" id="edit_<?php echo $id; ?>" onclick="openEditModal('<?php echo $id; ?>')">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25" height="25" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve">
                                        <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style>
                                        <g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g>
                                    </svg>
                                </a>
                                <a class="delete" id="delete_<?php echo $id; ?>" onclick="openDeleteModal('<?php echo $id; ?>', '<?php echo $fullName; ?>')">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25" height="25" viewBox="0 0 109.484 122.88" enable-background="new 0 0 109.484 122.88" xml:space="preserve">
                                        <g><path fill-rule="evenodd" clip-rule="evenodd" d="M2.347,9.633h38.297V3.76c0-2.068,1.689-3.76,3.76-3.76h21.144 c2.07,0,3.76,1.691,3.76,3.76v5.874h37.83c1.293,0,2.347,1.057,2.347,2.349v11.514H0V11.982C0,10.69,1.055,9.633,2.347,9.633 L2.347,9.633z M8.69,29.605h92.921c1.937,0,3.696,1.599,3.521,3.524l-7.864,86.229c-0.174,1.926-1.59,3.521-3.523,3.521h-77.3 c-1.934,0-3.352-1.592-3.524-3.521L5.166,33.129C4.994,31.197,6.751,29.605,8.69,29.605L8.69,29.605z M69.077,42.998h9.866v65.314 h-9.866V42.998L69.077,42.998z M30.072,42.998h9.867v65.314h-9.867V42.998L30.072,42.998z M49.572,42.998h9.869v65.314h-9.869 V42.998L49.572,42.998z"/></g>
                                    </svg>
                                </a>
                            </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
                }

                ?>
            </tbody>
            </table>
        </div>

        <!-- EDIT INFORMATION -->
        <dialog class="Edmodal" id="Emodal">
            <div class="Eclose-mod">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="EcloseBTN" onclick="document.getElementById('Emodal').close();" style="cursor: pointer;">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
            <div class="EM-header">
                <h1>Edit Driver's Information</h1>
            </div>
            <form action="update.php" method="post" class="editform">
            <div class="EMM-body">
                <div class="EMMsub-body">
                    <h1>Driver's Information</h1>
                    <div class="Einput-body">
                        <input type="hidden" name="id" id="driver_id" value="">
                        <div class="EFname-P">
                            <p>Full Name<span>*</span></p>
                            <input type="text" name="FName" id="edit_FName" required autocomplete="off">
                        </div>
                        <div class="EAddress-P">
                            <p>Address<span>*</span></p>
                            <input type="text" name="Address" id="edit_Address" required autocomplete="off">
                        </div>
                        <div class="ELicNo-P">
                            <p>Licence Number<span>*</span></p>
                            <input type="text" name="LicNo" id="edit_LicNo" required autocomplete="off">
                        </div>
                        <div class="EEDate-P">
                            <p>Expiration Date<span>*</span></p>
                            <input type="date" name="EDate" id="edit_EDate" title="Please enter a valid date in the format MM/DD/YYYY" required autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="EBtn-body">
                <input id="EM-btn" type="submit" value="Update">
                <input id="ECM-btn" value="Cancel" onmousedown="return false;" readonly>
            </div>
            </form>
        </dialog>

        <script>

        </script>

        <!-- DELETE INFORMATION -->
        <dialog id="Dmodal" class="DelModal">
            <div class="DHeader" style="margin-top: 2%;">
                <h1>DELETE RECORD</h1>
                <p>You're about to delete a record. Please note deleted record cannot</p>
                <p>be recovered. Do you wish to proceed?</p>
            </div>
            <div class="Dmain-con">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25" height="25" viewBox="0 0 109.484 122.88" enable-background="new 0 0 109.484 122.88" xml:space="preserve">
                    <g><path fill="red" fill-rule="evenodd" clip-rule="evenodd" d="M2.347,9.633h38.297V3.76c0-2.068,1.689-3.76,3.76-3.76h21.144 c2.07,0,3.76,1.691,3.76,3.76v5.874h37.83c1.293,0,2.347,1.057,2.347,2.349v11.514H0V11.982C0,10.69,1.055,9.633,2.347,9.633 L2.347,9.633z M8.69,29.605h92.921c1.937,0,3.696,1.599,3.521,3.524l-7.864,86.229c-0.174,1.926-1.59,3.521-3.523,3.521h-77.3 c-1.934,0-3.352-1.592-3.524-3.521L5.166,33.129C4.994,31.197,6.751,29.605,8.69,29.605L8.69,29.605z M69.077,42.998h9.866v65.314 h-9.866V42.998L69.077,42.998z M30.072,42.998h9.867v65.314h-9.867V42.998L30.072,42.998z M49.572,42.998h9.869v65.314h-9.869 V42.998L49.572,42.998z"/></g>
                </svg>
                <div id="fullNamePlaceholder">
                    <p id="fullName">Delete <strong></strong><strong>'s</strong> records in the <strong>Table</strong></p>
                </div>
            </div>
            <hr>
            <div class="DBtn-body">
                <a id="DM-btn" href="delete.php" onmousedown="return false;" readonly>YES • Delete</a>
                <input id="DCM-btn" onclick="document.getElementById('Dmodal').close();" value="NO • Cancel" onmousedown="return false;" readonly>
            </div>
        </dialog>
    </main>
</body>
</html>
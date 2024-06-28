<?php
session_start();

// periksa apakah admin sudah login
if (!isset($_SESSION['email'])) {
    // jika belum, pergi ke halaman index.php
    header('Location: index.php');
    exit();
}

// periksa apakah admin sudah login dan role-nya adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboarduser.php"); // jika bukan admin, arahkan ke dashboarduser.php
    exit();
}

include 'connectdatabase.php';

// Email yang ingin dicari
$getEmail = $_SESSION["email"];

class DashboardAdmin {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTotalStudents() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_students FROM registration");
        $row = mysqli_fetch_assoc($query);
        return $row['total_students'];
    }

    public function getTotalRooms() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_rooms FROM room_info");
        $row = mysqli_fetch_assoc($query);
        return $row['total_rooms'];
    }

    public function getTotalRegisteredComplaints() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_registered_complaints FROM register_complaint");
        $row = mysqli_fetch_assoc($query);
        return $row['total_registered_complaints'];
    }

    public function getTotalNewComplaints() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_new_complaints FROM register_complaint WHERE complaint_status = 'unprocessed'");
        $row = mysqli_fetch_assoc($query);
        return $row['total_new_complaints'];
    }

    public function getTotalInProcessComplaints() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_in_process_complaints FROM register_complaint WHERE complaint_status = 'In Process'");
        $row = mysqli_fetch_assoc($query);
        return $row['total_in_process_complaints'];
    }

    public function getTotalClosedComplaints() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_closed_complaints FROM register_complaint WHERE complaint_status = 'Closed'");
        $row = mysqli_fetch_assoc($query);
        return $row['total_closed_complaints'];
    }

    public function getTotalFeedbacks() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) AS total_feedbacks FROM feedback");
        $row = mysqli_fetch_assoc($query);
        return $row['total_feedbacks'];
    }

    public function getAdminName($getEmail) {
        $queryName = mysqli_query($this->conn, "SELECT username FROM admin_login WHERE admin_email = '$getEmail'");
        if (!$queryName) {
            die("Query failed: " . mysqli_error($this->conn));
        }
        $nameResult = mysqli_fetch_assoc($queryName);
        return $nameResult['username'];
    }
}

$dashboard = new DashboardAdmin($conn);

// Mengambil data jumlah murid
$total_students = $dashboard->getTotalStudents();

// Mengambil data jumlah kamar
$total_rooms = $dashboard->getTotalRooms();

// Mengambil data jumlah registered complaints
$total_registered_complaints = $dashboard->getTotalRegisteredComplaints();

// Mengambil data jumlah new complaints
$total_new_complaints = $dashboard->getTotalNewComplaints();

// Mengambil data jumlah in process complaints
$total_in_process_complaints = $dashboard->getTotalInProcessComplaints();

// Mengambil data jumlah closed complaints
$total_closed_complaints = $dashboard->getTotalClosedComplaints();

// Mengambil data jumlah feedback
$total_feedbacks = $dashboard->getTotalFeedbacks();

$fullName = $dashboard->getAdminName($getEmail);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Unpri Hostel</title>
    <link rel="stylesheet" href="headerandnavbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="maincontent.css">
</head>
<body>
    <!-- header -->
    <header>
    <a href="dashboardadmin.php">Admin Unpri Hostel</a>
        <div class="user-info">
            <span><?php echo htmlspecialchars($fullName); ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="main">
        <!-- navbar -->
        <div class="navbar">
            <p id="none">MAIN</p>

            <div class="contentnavbar">
                <div class="iconnavbar">
                    <!-- icon dashboard -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 512 512"><path fill="#4e5459" d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm320 96c0-26.9-16.5-49.9-40-59.3V88c0-13.3-10.7-24-24-24s-24 10.7-24 24V292.7c-23.5 9.5-40 32.5-40 59.3c0 35.3 28.7 64 64 64s64-28.7 64-64zM144 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm-16 80a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM400 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                    
                    <!-- icon rooms -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 576 512"><path fill="#4e5459" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c.2 35.5-28.5 64.3-64 64.3H128.1c-35.3 0-64-28.7-64-64V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24zM352 224a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zm-96 96c-44.2 0-80 35.8-80 80c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16c0-44.2-35.8-80-80-80H256z"/></svg>

                    <!-- icon add room -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 576 512"><path fill="#4e5459" d="M386.5 111.5l15.1 249-11-.3c-36.2-.8-71.6 8.8-102.7 28-31-19.2-66.4-28-102.7-28-45.6 0-82.1 10.7-123.5 27.7L93.1 129.6c28.5-11.8 61.5-18.1 92.2-18.1 41.2 0 73.8 13.2 102.7 42.5 27.7-28.3 59-41.7 98.5-42.5zM569.1 448c-25.5 0-47.5-5.2-70.5-15.6-34.3-15.6-70-25-107.9-25-39 0-74.9 12.9-102.7 40.6-27.7-27.7-63.7-40.6-102.7-40.6-37.9 0-73.6 9.3-107.9 25C55.2 442.2 32.7 448 8.3 448H6.9L49.5 98.9C88.7 76.6 136.5 64 181.8 64 218.8 64 257 71.7 288 93.1 319 71.7 357.2 64 394.2 64c45.3 0 93 12.6 132.3 34.9L569.1 448zm-43.4-44.7l-34-280.2c-30.7-14-67.2-21.4-101-21.4-38.4 0-74.4 12.1-102.7 38.7-28.3-26.6-64.2-38.7-102.7-38.7-33.8 0-70.3 7.4-101 21.4L50.3 403.3c47.2-19.5 82.9-33.5 135-33.5 37.6 0 70.8 9.6 102.7 29.6 31.8-20 65.1-29.6 102.7-29.6 52.2 0 87.8 14 135 33.5z"/></svg>
                    
                    <!-- icon complaints -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 640 512"><path fill="#4e5459" d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"/></svg>

                    <!-- icon feedback -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 512 512"><path fill="#4e5459" d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6 .6-1 1.1-1.3 1.4l-.3 .3 0 0 0 0 0 0 0 0c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM224 160c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v48h48c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H288v48c0 8.8-7.2 16-16 16H240c-8.8 0-16-7.2-16-16V272H176c-8.8 0-16-7.2-16-16V224c0-8.8 7.2-16 16-16h48V160z"/></svg>

                    <!-- icon profile -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 576 512"><path fill="#4e5459" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 256h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zm256-32H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>

                    <!-- icon add admin -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 640 512"><path fill="#4e5459" d="M335.5 4l288 160c15.4 8.6 21 28.1 12.4 43.5s-28.1 21-43.5 12.4L320 68.6 47.5 220c-15.4 8.6-34.9 3-43.5-12.4s-3-34.9 12.4-43.5L304.5 4c9.7-5.4 21.4-5.4 31.1 0zM320 160a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM144 256a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm312 40a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM226.9 491.4L200 441.5V480c0 17.7-14.3 32-32 32H120c-17.7 0-32-14.3-32-32V441.5L61.1 491.4c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l37.9-70.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c16.3 0 31.9 4.5 45.4 12.6l33.6-62.3c15.3-28.5 45.1-46.3 77.5-46.3h19.5c32.4 0 62.1 17.8 77.5 46.3l33.6 62.3c13.5-8.1 29.1-12.6 45.4-12.6h19.5c32.4 0 62.1 17.8 77.5 46.3l37.9 70.3c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8L552 441.5V480c0 17.7-14.3 32-32 32H472c-17.7 0-32-14.3-32-32V441.5l-26.9 49.9c-6.3 11.7-20.8 16-32.5 9.8s-16-20.8-9.8-32.5l36.3-67.5c-1.7-1.7-3.2-3.6-4.3-5.8L376 345.5V400c0 17.7-14.3 32-32 32H296c-17.7 0-32-14.3-32-32V345.5l-26.9 49.9c-1.2 2.2-2.6 4.1-4.3 5.8l36.3 67.5c6.3 11.7 1.9 26.2-9.8 32.5s-26.2 1.9-32.5-9.8z"/></svg>
                </div>

                <div class="textnavbar">
                    <a href="dashboardadmin.php"><p id="dashboard">Dashboard</p></a>
                    <a href="roominfo.php"><p id="rooms">Rooms</p></a>
                    <a href="addroom.php"><p id="addRoom">Add Room</p></a>
                    <a href="registeredcomplaint.php"><p id="complaints">Complaints</p></a>
                    <a href="registeredfeedback.php"><p id="feedback">Feedback</p></a>
                    <a href="profileadmin.php"><p id="myProfile">My Profile</p></a>
                    <a href="addadmin.php"><p id="addAdmin">Add Admin</p></a>
                </div>
            </div>
        <!-- end of navbar -->
        </div>

        <!-- isi main content -->
        <div class="maincontent">
            <!-- teks untuk mengetahui tentang apa halaman tersebut -->
            <p id="userlogin">Dashboard</p>
            <hr>

            <div class="containermain">
                <div class="containersub">
                    <div class="admincontent" id="total_students">
                        <p class="total"><?php echo $total_students; ?></p>
                        <p>TOTAL STUDENTS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="students.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="total_rooms">
                        <p class="total"><?php echo $total_rooms; ?></p>
                        <p>TOTAL ROOMS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="roominfo.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="registered_complaints">
                        <p class="total"><?php echo $total_registered_complaints; ?></p>
                        <p>REGISTERED COMPLAINTS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="registeredcomplaint.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="new_complaints">
                        <p class="total"><?php echo $total_new_complaints; ?></p>
                        <p>NEW COMPLAINTS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="newcomplaint.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="in_process_complaints">
                        <p class="total"><?php echo $total_in_process_complaints; ?></p>
                        <p>IN PROCESS COMPLAINTS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="inprocesscomplaint.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="closed_complaints">
                        <p class="total"><?php echo $total_closed_complaints; ?></p>
                        <p>CLOSED COMPLAINTS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="closedcomplaint.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
                <div class="containersub">
                    <div class="admincontent" id="total_feedbacks">
                        <p class="total"><?php echo $total_feedbacks; ?></p>
                        <p>TOTAL FEEDBACKS</p>
                    </div>
                    <div class="fullinfo">
                        <a href="registeredfeedback.php"><p>FULL DETAIL</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
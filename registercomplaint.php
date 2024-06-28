<?php
session_start();

// Periksa apakah user sudah login dan role nya adalah user
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

include 'connectdatabase.php';

class ComplaintRegistration {
    private $conn;
    private $email;
    private $registrationNo;
    private $roomNo;
    private $fullName;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->email = $_SESSION["email"];
    }

    public function fetchUserDetails() {
        $this->registrationNo = $this->fetchRegistrationNo();
        $this->roomNo = $this->fetchRoomNo();
        $this->fullName = $this->fetchFullName();

        if (!$this->bookingExists()) {
            echo "<script>alert('You must book a room first before giving complaint.'); window.location.href = 'bookhostel.php';</script>";
            exit();
        }
    }

    private function fetchRegistrationNo() {
        $query = mysqli_query($this->conn, "SELECT registration_no FROM registration WHERE email = '$this->email'");
        return mysqli_fetch_assoc($query)['registration_no'];
    }

    private function fetchRoomNo() {
        $query = mysqli_query($this->conn, "SELECT room_no FROM book_room WHERE registration_no = '$this->registrationNo'");
        return mysqli_fetch_assoc($query)['room_no'];
    }

    private function fetchFullName() {
        $query = mysqli_query($this->conn, "SELECT full_name FROM registration WHERE email = '$this->email'");
        $result = mysqli_fetch_assoc($query);
        return $result['full_name'];
    }

    private function bookingExists() {
        $query = mysqli_query($this->conn, "SELECT * FROM book_room WHERE registration_no = '$this->registrationNo'");
        return mysqli_num_rows($query) > 0;
    }

    public function registerComplaint() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $complaint_type = $_POST['complaint_type'];
            $explain_complaint = $_POST['explain_complaint'];
            $file_name = $_POST['file_name'];
            $complaint_status = 'unprocessed';

            $timezone = new DateTimeZone('Asia/Jakarta');
            $time = new DateTime('now', $timezone);
            $complaint_date = $time->format('Y-m-d H:i:s');

            $sql = "INSERT INTO register_complaint (registration_no, room_no, complaint_type, explain_complaint, file_name, complaint_status, complaint_date) 
                    VALUES ('$this->registrationNo', '$this->roomNo', '$complaint_type', '$explain_complaint', '$file_name', '$complaint_status', '$complaint_date')";
            if (mysqli_query($this->conn, $sql)) {
                header("Location: mycomplaint.php");
                exit();
            }
        }
    }

    public function getFullName() {
        return $this->fullName;
    }
}

$complaintRegistration = new ComplaintRegistration($conn);
$complaintRegistration->fetchUserDetails();
$complaintRegistration->registerComplaint();

$fullName = $complaintRegistration->getFullName();

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unpri Hostel</title>
    <link rel="stylesheet" href="headerandnavbar.css">
    <link rel="stylesheet" href="maincontent.css">
    <link rel="stylesheet" href="registercomplaint.css">
</head>
<body>
    <!-- header -->
    <header>
        <a href="dashboarduser.php">Hostel Management System</a>
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

                    <!-- icon book_hostel -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 448 512"><path fill="#4e5459" d="M0 96C0 43 43 0 96 0H384h32c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32v64c17.7 0 32 14.3 32 32s-14.3 32-32 32H384 96c-53 0-96-43-96-96V96zM64 416c0 17.7 14.3 32 32 32H352V384H96c-17.7 0-32 14.3-32 32zM208 112v48H160c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h48v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V224h48c8.8 0 16-7.2 16-16V176c0-8.8-7.2-16-16-16H272V112c0-8.8-7.2-16-16-16H224c-8.8 0-16 7.2-16 16z"/></svg>

                    <!-- icon room details -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 640 512"><path fill="#4e5459" d="M320 368c0 59.5 29.5 112.1 74.8 144H128.1c-35.3 0-64-28.7-64-64V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L522.1 193.9c-8.5-1.3-17.3-1.9-26.1-1.9c-54.7 0-103.5 24.9-135.8 64H320V208c0-8.8-7.2-16-16-16H272c-8.8 0-16 7.2-16 16v48H208c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h48v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16zM496 224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm0-192c-8.8 0-16 7.2-16 16v80c0 8.8 7.2 16 16 16s16-7.2 16-16V288c0-8.8-7.2-16-16-16z"/></svg>

                    <!-- icon complaint registration -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 512 512"><path fill="#4e5459" d="M64 208.1L256 65.9 448 208.1v47.4L289.5 373c-9.7 7.2-21.4 11-33.5 11s-23.8-3.9-33.5-11L64 255.5V208.1zM256 0c-12.1 0-23.8 3.9-33.5 11L25.9 156.7C9.6 168.8 0 187.8 0 208.1V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V208.1c0-20.3-9.6-39.4-25.9-51.4L289.5 11C279.8 3.9 268.1 0 256 0z"/></svg>

                    <!-- icon registered complaints -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 640 512"><path fill="#4e5459" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>

                    <!-- icon feedback -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 512 512"><path fill="#4e5459" d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6 .6-1 1.1-1.3 1.4l-.3 .3 0 0 0 0 0 0 0 0c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM224 160c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v48h48c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H288v48c0 8.8-7.2 16-16 16H240c-8.8 0-16-7.2-16-16V272H176c-8.8 0-16-7.2-16-16V224c0-8.8 7.2-16 16-16h48V160z"/></svg>

                    <!-- icon my profile -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 384 512"><path fill="#4e5459" d="M256 48V64c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H256zM0 64C0 28.7 28.7 0 64 0H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM160 320h64c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"/></svg>

                    <!-- icon change password -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 512 512"><path fill="#4e5459" d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg>

                </div>

                <div class="textnavbar">
                    <a href="dashboarduser.php"><p id="dashboard">Dashboard</p></a>
                    <a href="bookhostel.php"><p id="book_hostel">Book Hostel</p></a>
                    <a href="roomdetail.php"><p id="room_details">Room Details</p></a>
                    <a href="registercomplaint.php"><p id="complaint_registration">Complaint Registration</p></a>
                    <a href="mycomplaint.php"><p id="registered_complaints">Registered Complaints</p></a>
                    <a href="feedback.php"><p id="feedback">Feedback</p></a>
                    <a href="profile.php"><p id="my_profile2">My Profile</p></a>
                    <a href="changepassword.php"><p id="change_password">Change Password</p></a>
                </div>
            </div>
        <!-- end of navbar -->
        </div>

        <!-- isi main content -->
        <div class="maincontent">
            <!-- teks untuk mengetahui tentang apa halaman tersebut -->
            <p id="userlogin">Register Complaint</p>
            <hr>

            <div class="container">
                <div class="box">
                    <form class="form" method="post">
                        <div class="fillform">
                            <p>Complaint Type: 
                                <select name="complaint_type" id="complaint_type" required>
                                    <option value="food related" name="food_related">Food Related</option>
                                    <option value="room related" name="room_related">Room Related</option>
                                    <option value="fee related" name="fee_related">Fee Related</option>
                                    <option value="electrical" name="electrical">Electrical</option>
                                    <option value="plumbing" name="plumbing">Plumbing</option>
                                    <option value="discipline" name="discipline">Discipline</option>
                                    <option value="other" name="other">Other</option>
                                </select>
                            </p>
                            <p>Explain the Complaint: <input type="textarea" name="explain_complaint" id="explain_complaint"></p>
                            <p>File (if any): <input type="file" name="file_name" id="file_name" accept="image/*, .pdf"></p>
                            <div class="buttonform">
                                <button type="reset"><a href="dashboarduser.php">Cancel</a></button>
                                <button type="submit" id="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

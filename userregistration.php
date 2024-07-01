<?php
session_start();
include 'connectdatabase.php';

class UserRegistration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getNextRegistrationNo() {
        $query = mysqli_query($this->conn, "SELECT MAX(registration_no) AS max_registration_no FROM registration");
        $row = mysqli_fetch_assoc($query);
        return $row['max_registration_no'] + 1;
    }

    public function registerUser($registrationNo, $fullName, $gender, $contactNo, $email, $password) {
        $registrationNo = mysqli_real_escape_string($this->conn, $registrationNo);
        $fullName = mysqli_real_escape_string($this->conn, $fullName);
        $gender = mysqli_real_escape_string($this->conn, $gender);
        $contactNo = mysqli_real_escape_string($this->conn, $contactNo);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);

        $sql = "INSERT INTO registration (registration_no, full_name, gender, contact_no, email, password) 
                VALUES ('$registrationNo', '$fullName', '$gender', '$contactNo', '$email', '$password')";
        
        return mysqli_query($this->conn, $sql);
    }
}

$userRegistration = new UserRegistration($conn);

$next_registration_no = $userRegistration->getNextRegistrationNo();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationNo = $_POST['registrationNo'];
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $contactNo = $_POST['contactNo'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userRegistration->registerUser($registrationNo, $fullName, $gender, $contactNo, $email, $password)) {
        header('Location: index.php');
    } else {
        echo '<script>alert("Email is already taken. Please use another email")</script>';
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unpri Hostel</title>
    <link rel="stylesheet" href="indexheaderandnavbar.css">
    <link rel="stylesheet" href="bookhostel.css">
    <link rel="stylesheet" href="maincontent.css">
</head>
<body>
    <!-- header -->
    <header><a href="#">Hostel Management System</a></header>

    <div class="main">
        <!-- navbar -->
        <div class="navbar">
            <p id="none">MAIN</p>

            <div class="contentnavbar">
                <div class="iconnavbar">
                    <!-- icon registration -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18.5" viewBox="0 0 640 512"><path fill="#4E5459" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>

                    <!-- icon user login -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 448 512"><path fill="#4e5459" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>

                    <!-- icon admin login -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="18" width="20.5" viewBox="0 0 448 512"><path fill="#4e5459" d="M224 16c-6.7 0-10.8-2.8-15.5-6.1C201.9 5.4 194 0 176 0c-30.5 0-52 43.7-66 89.4C62.7 98.1 32 112.2 32 128c0 14.3 25 27.1 64.6 35.9c-.4 4-.6 8-.6 12.1c0 17 3.3 33.2 9.3 48H45.4C38 224 32 230 32 237.4c0 1.7 .3 3.4 1 5l38.8 96.9C28.2 371.8 0 423.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7c0-58.5-28.2-110.4-71.7-143L415 242.4c.6-1.6 1-3.3 1-5c0-7.4-6-13.4-13.4-13.4H342.7c6-14.8 9.3-31 9.3-48c0-4.1-.2-8.1-.6-12.1C391 155.1 416 142.3 416 128c0-15.8-30.7-29.9-78-38.6C324 43.7 302.5 0 272 0c-18 0-25.9 5.4-32.5 9.9c-4.8 3.3-8.8 6.1-15.5 6.1zm56 208H267.6c-16.5 0-31.1-10.6-36.3-26.2c-2.3-7-12.2-7-14.5 0c-5.2 15.6-19.9 26.2-36.3 26.2H168c-22.1 0-40-17.9-40-40V169.6c28.2 4.1 61 6.4 96 6.4s67.8-2.3 96-6.4V184c0 22.1-17.9 40-40 40zm-88 96l16 32L176 480 128 288l64 32zm128-32L272 480 240 352l16-32 64-32z"/></svg>
                </div>

                <div class="textnavbar">
                    <a href="userregistration.php"><p>User Registration</p></a>
                    <a href="index.php"><p>User Login</p></a>
                    <a href="adminlogin.php"><p>Admin Login</p></a>
                </div>
            </div>
        <!-- end of navbar -->
        </div>

        <!-- isi main content -->
        <div class="maincontent">
            <!-- teks untuk mengetahui tentang apa halaman tersebut -->
            <p id="userlogin">User Registration</p>
            <hr>

            <div class="formcontainer">
                <p>FILL ALL INFO</p>

                <form class="form" method="post" action="userregistration.php">
                    <div class="fillform">
                        <p>Registration No: <input type="text" name="registrationNo" value="<?php echo $next_registration_no; ?>" readonly></p>
                        <p>Full Name: <input type="text" name="fullName" required></p>
                        <p>Gender: 
                            <select name="gender" id="gender" required>
                                <option value="Male" name="male">Male</option>
                                <option value="Female" name="female">Female</option>
                            </select>
                        </p>
                        <p>Contact No: <input type="number" name="contactNo" required></p>
                        <p>Email: <input type="email" name="email" required></p>
                        <p>Password: <input type="password" name="password" id="password" required></p>
                        <p>Confirm Password: <input type="password" name="confirmPassword" id="confirmPassword" required></p>
                        <p id="error-message">Passwords do not match!</p>
                        <div class="buttonform">
                            <button type="reset">Reset</button>
                            <button type="submit" id="registerButton">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="confirmPassword.js"></script>
</body>
</html>

<?php
header('Content-Type: application/json');

include 'connectdatabase.php';

class RoomDataFetcher {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getRoomData($roomNo) {
        $result = mysqli_query($this->conn, "SELECT seater, fees_per_month FROM room_info WHERE room_no = '$roomNo'");

        if ($result) {
            if ($row = mysqli_fetch_assoc($result)) {
                return ['success' => true, 'seater' => $row['seater'], 'fees_per_month' => $row['fees_per_month']];
            } else {
                return ['success' => false, 'message' => 'Room not found'];
            }
        } else {
            return ['success' => false, 'message' => 'Query failed: ' . mysqli_error($this->conn)];
        }
    }
}

// Cek apakah room_no sudah di set
if (isset($_GET['room_no'])) {
    $roomNo = $_GET['room_no'];

    $fetcher = new RoomDataFetcher($conn);
    $result = $fetcher->getRoomData($roomNo);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Room number not provided']);
}

mysqli_close($conn);
?>
function fetchRoomData() {
    const roomNo = document.getElementById('room_no').value;

    fetch(`getroomdata.php?room_no=${roomNo}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('seater').value = data.seater;
                document.getElementById('fees_per_month').value = data.fees_per_month;
            } else {
                alert('Failed to fetch room data');
            }
        })
        .catch(error => console.error('Error:', error));
}
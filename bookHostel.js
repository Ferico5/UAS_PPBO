// ambil data room
window.onload = function() {
    document.getElementById('room_no').addEventListener('change', function() {
        let roomNo = this.value;

        fetch('getroomdata.php?room_no=' + roomNo)
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('seater').value = data.seater;
                    document.getElementById('fees_per_month').value = data.fees_per_month;
                } else {
                    alert('Failed to fetch room data: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });
};


// mencegah user untuk memilih tanggal yang sudah lewat
const stayFromInput = document.getElementById('stayFrom');
const today = new Date();
const day = String(today.getDate()).padStart(2, '0');
const month = String(today.getMonth() + 1).padStart(2, '0'); // +1 karena bulan dimulai dari 0
const year = today.getFullYear();
const minDate = year + '-' + month + '-' + day; // membuat format YYYY-MM-DD
stayFromInput.setAttribute('min', minDate); // menset atribut min agar user tidak bisa memilih tanggal yang sudah lewat

// mencegah user memilih opsi Choose Room Number Room No
const roomNo = document.getElementById('room_no');
const form = document.querySelector('.form');

form.addEventListener('submit', (e) => {
    if (roomNo.value === "Choose Room Number") {
        e.preventDefault();
        alert("Please choose room number");
    }
})


document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("updateModal");
    const btn = document.getElementById("update");
    const span = document.getElementsByClassName("close")[0];
    const closeBtn = document.getElementById("closeBtn");

    btn.addEventListener('click', (event) => {
        event.preventDefault();
        modal.style.display = "block";
    });

    // Jika user menekan tombol x, maka hilangkan
    span.addEventListener('click', () => {
        modal.style.display = "none";
    });

    // Jika user menekan button close, maka hilangkan
    closeBtn.addEventListener('click', () => {
        modal.style.display = "none";
    });

    // Jika user menekan di luar kotak window, hilangkan
    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
});
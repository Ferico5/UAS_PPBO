function validateForm() {
    const accessibilityToWarden = document.getElementsByName('accessibility_to_warden');
    const accessibilityToCommittee = document.getElementsByName('accessibility_to_hostel_committee_members');
    const redressalOfProblems = document.getElementsByName('redressal_of_problems');
    const room = document.getElementsByName('room');
    const mess = document.getElementsByName('mess');
    const hostelSurroundings = document.getElementsByName('hostel_surroundings');
    const overallRating = document.getElementsByName('overall_rating');

    // Fungsi untuk memeriksa apakah setidaknya satu radio button dipilih
    function isRadioSelected(radioButtons) {
        for (let i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                return true;
            }
        }
        return false;
    }

    // Memeriksa apakah radio sudah dipilih
    if (!isRadioSelected(accessibilityToWarden) ||
        !isRadioSelected(accessibilityToCommittee) ||
        !isRadioSelected(redressalOfProblems) ||
        !isRadioSelected(room) ||
        !isRadioSelected(mess) ||
        !isRadioSelected(hostelSurroundings) ||
        !isRadioSelected(overallRating)) {
        alert("Harap pilih salah satu opsi untuk setiap pertanyaan.");
        return false;
    }

    return true;
}
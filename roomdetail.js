document.addEventListener('DOMContentLoaded', () => {
    // mendapat hostel fee
    const feesPerMonth = document.getElementById('fees_per_month');
    const duration = document.getElementById('duration');
    const hostelFee = document.getElementById('hostel_fee');

    const intFeesPerMonth = parseInt(feesPerMonth.innerText);
    const intDuration = parseInt(duration.innerText);

    const totalHostelFee = intFeesPerMonth * intDuration;

    hostelFee.innerText = totalHostelFee;

    // mendapat food fee
    const foodStatus = document.getElementById('food_status');
    const foodFee = document.getElementById('food_fee');

    if (foodStatus.innerText == "without_food") {
        foodFee.innerText = 0;
    } else if (foodStatus.innerText == "with_food") {
        foodFee.innerText = 350000 * intDuration;
    }

    // mendapat total fee
    const totalFee = document.getElementById('total_fee');
    totalFee.innerText = parseInt(hostelFee.innerText) + parseInt(foodFee.innerText);
})


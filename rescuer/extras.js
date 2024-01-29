document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById('check');
    const sidebar = document.getElementById('sidebar');
    const chBtn = document.querySelector('.chBtn');
    const chBtn2 = document.querySelector('.chBtn2');

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            sidebar.style.width = '250px'; // Show sidebar by setting its width
            chBtn.style.display = 'none'; // Show chBtn
        } else {
            sidebar.style.width = '0'; // Hide sidebar by setting its width to 0
        }
    });

    chBtn2.addEventListener('click', function() {
        if (checkbox.checked) {
            chBtn.style.display = 'block'; // Show chBtn when chBtn2 is clicked and sidebar is checked
        }
    });
});
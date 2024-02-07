document.addEventListener("DOMContentLoaded", function() {
    const checkbox = document.getElementById('check');
    const sidebar = document.getElementById('sidebar');
    const chBtn = document.querySelector('.chBtn');
    const chBtn2 = document.querySelector('.chBtn2');

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            sidebar.style.width = '250px'; 
            chBtn.style.display = 'none'; 
        } else {
            sidebar.style.width = '0'; //Hide sidebar 
        }
    });

    chBtn2.addEventListener('click', function() {
        if (checkbox.checked) {
            chBtn.style.display = 'block'; //Show chBtn when chBtn2 is clicked and sidebar is checked
        }
    });


});
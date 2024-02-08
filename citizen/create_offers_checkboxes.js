document.addEventListener('DOMContentLoaded', function () {
    //Fetch checkboxes when the page loads
    fetchCheckboxes();
});

//Function to fetch checkboxes via AJAX
function fetchCheckboxes() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'create_offers_checkboxes.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const announcementCheckboxContainer = document.querySelector('.announcement-checkbox-container');
            announcementCheckboxContainer.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

//Function to submit selected announcements
function submitSelectedAnnouncements() {
    const form = document.getElementById('submitAnnouncementsForm');
    const selectedAnnouncementsMessage = document.getElementById('selectedAnnouncementsMessage');

    //Check if there are selected announcements
    const selectedAnnouncements = form.querySelectorAll('input[name="selectedAnnouncements[]"]:checked');

    //Check if there are selected announcements
    if (form && form.elements['selectedAnnouncements[]']) {
        const selectedAnnouncements = form.elements['selectedAnnouncements[]'];

        //If selectedAnnouncements is present, use its length property
        if (selectedAnnouncements.length > 0) {
            // Clear the message
            selectedAnnouncementsMessage.innerHTML = '';

            //Submit the form via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_citizen_announcement_submission_offers.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    console.log('Response:', xhr.responseText); // Log the response for debugging
                    if (xhr.status === 200) {
                        //Remove selected announcements from the DOM
                        selectedAnnouncements.forEach(input => {
                            const announcementContainer = input.closest('.offer-container');
                            if (announcementContainer) {
                                announcementContainer.remove();
                            }
                        });

                        //Trigger asynchronous update after successful submission
                        updateAnnouncements();
                    } else {
                        console.error('Error submitting announcements: ' + xhr.statusText);
                    }
                }
            };
            xhr.send(new URLSearchParams(new FormData(form)));
            const selectedIds = Array.from(selectedAnnouncements).map(input => input.value);
            console.log('Selected IDs:', selectedIds);
        } else {
            //Display a message when no checkboxes are selected
            selectedAnnouncementsMessage.innerHTML = 'Please select at least one announcement.';
        }
    } else {
        console.error('Form or form element with name "selectedAnnouncements[]" not found.');
    }
}

//Function to trigger asynchronous update of announcements
function updateAnnouncements() {
    //Fetch and update announcements asynchronously
    fetchAnnouncements();
    fetchCheckboxes();
}


document.addEventListener('DOMContentLoaded', function () {
    // Fetch announcements when the page loads
    fetchAnnouncements();
});

// Function to fetch announcements via AJAX
function fetchAnnouncements() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_current_requests.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const announcementsContainer = document.getElementById('announcementsContainer');
            announcementsContainer.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}



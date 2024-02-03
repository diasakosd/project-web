const ctx = document.getElementById('myChart');
let myChart; // Declare a variable to hold the chart instance

// Fetch data from the server using AJAX
function fetchDataByDateRange(startDate, endDate) {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `chart_data.php?startDate=${startDate}&endDate=${endDate}`, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          resolve(JSON.parse(xhr.responseText));
        } else {
          reject('Error fetching data');
        }
      }
    };
    xhr.send();
  });
}

// Use async function to wait for data before creating the chart
async function createChart() {
  try {
    // Initial load without date filter
    const data = await fetchDataByDateRange('', '');
    renderChart(data);
  } catch (error) {
    console.error(error);
  }
}

// Function to render or update the chart
function renderChart(data) {
  // Destroy the existing chart if it exists
  if (myChart) {
    myChart.destroy();
  }

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['New Requests', 'New Offers', 'Requests Completed', 'Offers Completed'],
      datasets: [{
        label: '# of Actions',
        data: [data.newRequests, data.newOffers, data.requestsCompleted, data.offersCompleted],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}

// Function to update the chart based on the selected date range
async function updateChart() {
  try {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    const data = await fetchDataByDateRange(startDate, endDate);
    renderChart(data);
  } catch (error) {
    console.error(error);
  }
}

// Call the function to create the chart initially
createChart();

const ctx = document.getElementById('myChart');

// Fetch data from the server using AJAX
function fetchData() {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'chart_data.php', true);
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
    const data = await fetchData();
    new Chart(ctx, {
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
  } catch (error) {
    console.error(error);
  }
}

// Call the function to create the chart
createChart();

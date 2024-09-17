document.getElementById('startDate').addEventListener('change', fetchSearches);
document.getElementById('endDate').addEventListener('change', fetchSearches);

function fetchSearches() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;

    if (startDate && endDate) {
        fetch('/nida/scripts/fetch_searches_by_date.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'startDate': startDate,
                'endDate': endDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                // Display the search count
                document.getElementById('searchFrequencyChart').innerHTML = 
                    `<h3> ${data.search_count}</h3>`;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }
}

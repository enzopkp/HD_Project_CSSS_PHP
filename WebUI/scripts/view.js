function fetchUserDetails(type, id) {
    fetch('../../Application/Services/GetUserDetailsService.php?type=' + type + '&id=' + id)
        .then(function(response) {
            console.log(response);
            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }
            return response.text(); // Get the response as text
        })
        .then(function(responseText) {
            console.log(responseText); // Log the response text
            var userDetails = JSON.parse(responseText); // Attempt to parse the response as JSON
            renderUserDetails(userDetails);
        })
        .catch(function(error) {
            console.log('Fetch failed: ', error);
        });
}

function renderUserDetails(userDetails) {
    var userDetailsDiv = document.getElementById('userDetails');
    userDetailsDiv.innerHTML = '';

    for (var key in userDetails) {
        userDetailsDiv.innerHTML += '<b>' + key + ':</b> ' + userDetails[key] + '<br>';
    }
}
    
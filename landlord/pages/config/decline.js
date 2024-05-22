
function declineReservation(reservationId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_reservation.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Check if the response is "Success"
                if (xhr.responseText.trim() === "Success") {
                    // Show the modal if the response is "Success"
                    $('#successModal').modal('show');
                    // Reload the page after a delay
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    console.error("Error: " + xhr.responseText);
                    alert("Error: " + xhr.responseText);
                }
            } else {
                console.error("Error: " + xhr.status);
                alert("Error: " + xhr.status);
            }
        }
    };

    xhr.send("reservation_id=" + reservationId + "&action=decline");
}

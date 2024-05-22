
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting traditionally

    var email = document.getElementById("yourEmail").value;
    var password = document.getElementById("yourPassword").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process_login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    // Redirect to a different page if login is successful
                    window.location.href = "/iBalay/landlord/index.php";
                } else {
                    // Handle login failure
                    document.getElementById("yourEmail").classList.add("is-invalid");
                    document.getElementById("yourPassword").classList.add("is-invalid");
                }
            }
        }
    };

    xhr.send("email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password));
});

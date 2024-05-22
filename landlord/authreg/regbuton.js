
  document.addEventListener("DOMContentLoaded", function() {
    // Get the form and register button
    var form = document.querySelector("form");
    var submitButton = document.querySelector("button[type='submit']");

    // Initial state of the button
    submitButton.disabled = true;

    // Function to check form validity
    function checkFormValidity() {
      submitButton.disabled = !form.checkValidity(); // If form is not valid, disable the button
    }

    // Add event listeners to the form fields
    form.addEventListener("input", checkFormValidity); // Trigger on any input change

    // Validate the form when the page loads
    checkFormValidity();
  });


const allowedMimeTypes = [
    'application/pdf',
    'application/vnd.ms-excel', 
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/msword', 
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

function validateFileType(inputElement, errorElement, submitButton) {
    const file = inputElement.files[0];
    let isValid = true;

    if (file) {
        const mimeType = file.type;
        if (!allowedMimeTypes.includes(mimeType)) {
            errorElement.textContent = "Invalid file type. Please upload a supported document.";
            inputElement.style.border = '2px solid red';
            isValid = false;
        } else {
            errorElement.textContent = "";
            inputElement.style.border = '';
        }
    } else {
        errorElement.textContent = "";
        inputElement.style.border = '';
    }

    // Enable or disable the submit button based on the current field validity
    submitButton.disabled = !isValid;
}

function validateForm(form) {
    const submitButton = form.querySelector('#submitBtn');
    const errorElements = form.querySelectorAll('.error');
    let allValid = true;

    // If there's any error message, the form is not valid
    errorElements.forEach(error => {
        if (error.textContent) {
            allValid = false;
        }
    });

    // If all are valid, enable the submit button; otherwise, keep it disabled
    submitButton.disabled = !allValid;
}
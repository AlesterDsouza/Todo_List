

var submitBtn = document.getElementById('submitBtn');
var taskError= document.getElementById('task-error');


var vTask = false;

// Restrict input to alphabetic characters for first name
// function restrictFirstNameInput(event) {
//     const value = event.target.value;
//     event.target.value = value.replace(/[^a-zA-Z ]/g, ''); 
//     validateFirstName();
// }

// // Restrict input to alphabetic characters for last name
// function restrictLastNameInput(event) {
//     const value = event.target.value;
//     event.target.value = value.replace(/[^a-zA-Z ]/g, ''); 
//     validateLastName();
// }




function validateTask() {
    var task = document.getElementById('Task').value;

    if (task.length === 0) {
        taskError.innerHTML = 'Task is required';
        taskError.style.color= 'red';
        taskError.classList.remove('success');
        taskError.classList.add('error');
        vTask = false;
    } else {
        taskError.innerHTML = 'Valid Task';
        taskError.style.color= 'green';
        taskError.classList.remove('error');
        taskError.classList.add('success');
        vTask = true;
    }
    checkSubmitButton();
}




// Check if all validations pass and enable/disable the submit button
function checkSubmitButton() {
    if (vTask) {
        submitBtn.disabled = false; // Enable submit button
    } else {
        submitBtn.disabled = true; // Disable submit button
    }
}

// Event listeners for validation

document.getElementById('Task').addEventListener('change', validateTask);


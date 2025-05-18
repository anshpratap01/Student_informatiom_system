// JavaScript validation 
document.querySelector("form").addEventListener("submit", function(event) {
    let name = document.querySelector('input[name="first_name"]').value;
    if (name.trim() === "") {
        alert("First Name is required!");
        event.preventDefault();
    }
});

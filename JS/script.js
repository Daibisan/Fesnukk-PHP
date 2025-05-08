function validateForm() {
    const username_input_value = document.getElementById("username_input").value.trim();
    // console.log("name" + username_input_value);

    const password_input_value = document.getElementById("pass_input").value.trim();
    // console.log("pass" + password_input_value);

    if (username_input_value === "") {
        alert("Username is required!");
        return false;
    }
    else if (password_input_value === "") {
        alert("Password is required!");
        return false;
    }
}
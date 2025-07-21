const validusername=/^[0-9]{2}[A-Z]{2,3}[0-9]{3}$/;

function checkusername() {
    let username = document.getElementById("username").value;
    if (validusername.test(username)) {
        document.getElementById("output").innerHTML = "Valid Username";
    } else {
        document.getElementById("output").innerHTML = "Invalid Username";
    }
}
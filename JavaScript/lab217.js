 function showDetails() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    document.getElementById('output');
    output.innerHTML =
      "<h3>Entered Details:</h3>"+
     " Username:"+ username+"<br>"+
      "Password:"+ password
    ;
 }
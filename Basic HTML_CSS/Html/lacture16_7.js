function add(a, b) {
    return a + b;
}
function sub(a, b) {
    return a - b;
}
function mul(a, b) {
    return a * b;
}
function div(a, b) {
    if (b === 0) {
        throw new Error("Division by zero is not allowed.");
    }
    return a / b;
}
function myfunc(){
    var str = "Aryan_Parikh";
    let str2 = "Aryan";
    const str3 = "Aryan Parikh";
    if (true) {
        str = "Aryan";
        console.log(str);
        let str2 = "Aryan Parikh";
        console.log(str2);
        const str3 = "Aryan";
        console.log(str3);
    }
    console.log(str);
    console.log(str2);
    console.log(str3);
}
function getsum(){
    let tex1=document.getElementById("tex1").value;
    let tex2=document.getElementById("tex2").value;
    let tex3=document.getElementById("tex2").value;
    document.writeln("The sum is: " + tex1+tex2 + "<br>");
}
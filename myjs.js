

function validate()
{
    console.log("We are validating");
    console.log(document.myForm.Fname.value);
    console.log(document.myForm.Lname.value);
    var errorArray = new Array();
   
    if (document.myForm.Fname.value == "")
    {
         
        alert( "Please provide your first name!" );
        document.myForm.Fname.focus();
        //return false;
        errorArray.push("You need a First Name"); 
    }
    window.location="CreateAccount.php";
    expression = /^[a-zA-Z]+$/;
    console.log(expression.test(document.myForm.Fname.value));
    if (!expression.test(document.getElementById("Fname").value)) {
        alert("you need to enter a valid First Name");
        document.myForm.Fname.focus();
        errorArray.push("You need the right format for your First Name");
    }

    if (document.myForm.Lname.value == "")
    {
        alert( "Please provide your last name!" );
        document.myForm.Lname.focus();
        //return false;
        errorArray.push("You need a Last Name");
    }
    expression = /^[a-zA-Z]+$/;
    console.log(expression.test(document.myForm.Lname.value));
    if (!expression.test(document.getElementById("Lname").value)) {
        alert("you need to enter a valid Last Name");
        document.myForm.Lname.focus();
        errorArray.push("You need the right format for your Last Name");
    }

    if (document.myForm.Email.value == "")
    {
        alert("Please provide your Email!");
        document.myForm.Email.focus();
        //return false;
        errorArray.push("you need a Email");
    }

    expression = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    console.log(expression.test(document.myForm.Email.value));
    if (!expression.test(document.getElementById("Email").value)) {
        alert("you need to enter a valid email, format name@server.com");
        document.myForm.Email.focus();
        errorArray.push("you need the right format for your email");
    }

    if (document.myForm.Password.value == "") {
        alert( "Please provide your password!" );
        document.myForm.Password.focus();
        //return false;
        errorArray.push("Please enter a Password");
    }


    if (errorArray.length > 0) {
        var errorReport = document.getElementById("errorlog");
        errorString = "<ul>";
        for (i = 0; i < errorArray.length; i++) {
            errorString = errorString + "<li>" + errorArray[i] + "</li>";
        }
        errorString = errorString + "</ul>";
        errorReport.innerHTML = errorString;
        return false;
    }
    return(true);
}
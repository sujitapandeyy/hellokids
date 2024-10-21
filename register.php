
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login And Registration</title>
    <link rel="stylesheet" href="style/login.css?v=1.7"/>
    <style>
        
            .formerror{
                color:red;
            }
        
        </style>
</head>
<body>
<?php
   
    ?>
<div class="popup-container" id="registerpopup" >
            <div class="popup">
    <form action ="login-reg.php" name="myForm" onsubmit="return validateForm()" method="post">
    <h2>

                    <span>User Register</span>
                    <button type="reset" ><a href="index.php">X</a></button>
                  
                </h2>
                <?php
                if(isset($_GET['error'])){?>
                    <p class="errormsg"><?php echo $_GET['error'];?></p>
                   
               <?php };
                ?>
        <!-- <div id="name">
            <input type="text" placeholder="Enter your Full Name" name="fname" ><b><span class="formerror"> </span></b>
        </div>
        <div id="name">
            <input type="text" placeholder="Enter user Name" name="uname" ><b><span class="formerror"> </span></b>
        </div>

        <div  id="email">
        <input type="email" placeholder="Enter Email" name="email"  /><span class="formerror" ></span><br/>
                </div>

        <div id="pass">
        <input type="password" placeholder="Password" name="password" /><span class="formerror" ></span><br/>
        </div>

        <div  id="cpass">
        <input type="password" placeholder="Confirm Password" name="cpassword" /><span class="formerror" ></span><br/>
        </div>

        <button type="Submit" class="registerbutton" name="register">Register Now</button>
                <p> <br/>Already have account ? <a href="login.php"><u>Login now</u></a></p> -->

        <input type="text" placeholder="Enter Full Name" name="fullname" id="Fullname"><span class="formerror" ></span><br/>
                <input type="text" placeholder="Enter User Name" name="username" ><span class="formerror" ></span><br/>
                <input type="email" placeholder="Enter Email" name="email"  /><span class="formerror" ></span><br/>
                <input type="password" placeholder="Password" name="password" /><span class="formerror" ></span><br/>
                <input type="password" placeholder="Confirm Password" name="cpassword" /><span class="formerror" ></span><br/>
                <input type="hidden" value="User" name="type" readonly /><br/>
                <button type="Submit" class="registerbutton" name="register">Register Now</button>
                <p> <br/>Already have account ? <a href="login.php"><u>Login now</u></a></p>

    </form>
        </div>
        </div>
</body>
<!-- <script >
    function clearErrors(){

errors = document.getElementsByClassName('formerror');
for(let item of errors)
{
    item.innerHTML = "";
}


}
function seterror(id, error){
//sets error inside tag of id 
element = document.getElementById(id);
element.getElementsByClassName('formerror')[0].innerHTML = error;

}

function validateForm(){
var returnval = true;
clearErrors();

//perform validation and if validation fails, set the value of returnval to false
var name = document.forms['myForm']["fname"].value;
if (name.length<5){
    seterror("name", "*Length of name is too short");
    returnval = false;
}

if (name.length == 0){
    seterror("name", "*Length of name cannot be zero!");
    returnval = false;
}

var email = document.forms['myForm']["femail"].value;
if (email.length>15){
    seterror("email", "*Email length is too long");
    returnval = false;
}

var phone = document.forms['myForm']["fphone"].value;
if (phone.length != 10){
    seterror("phone", "*Phone number should be of 10 digits!");
    returnval = false;
}

var password = document.forms['myForm']["password"].value;
if (password.length < 6){

    // Quiz: create a logic to allow only those passwords which contain atleast one letter, one number and one special character and one uppercase letter
    seterror("pass", "*Password should be atleast 6 characters long!");
    returnval = false;
}

var cpassword = document.forms['myForm']["cpassword"].value;
if (cpassword != password){
    seterror("cpass", "*Password and Confirm password should match!");
    returnval = false;
}

return returnval;
} -->


</script>

</html>


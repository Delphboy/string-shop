function validateRegisterForm()
{
    var email = document.forms["Registration-Form"]["RegistrationEmail"].value;
    var emailRep = document.forms["Registration-Form"]["RegistrationEmailConfirmation"].value;
    var pwd = document.forms["Registration-Form"]["RegistrationPassword"].value;
    var pwdRep = document.forms["Registration-Form"]["RegistrationPasswordConfirmation"].value;
    var mobNum = document.forms["Registration-Form"]["RegistrationMobileNumber"].value;

    var fail = validateEmail(email, emailRep);
    fail = fail + validatePasswordLength(pwd);
    fail = fail + validatePasswordMatch(pwd, pwdRep);
    fail = fail + validateMobNum(mobNum);

    if(fail == "")
        return true;
    else
    {
        alert(fail);
        return false;
    }
}

function validateEmail(email, emailRep)
{
    if(email === emailRep)
    {
        return "";
    }
    return "The emails that were entered do not match\n";
}

function validatePasswordLength(password)
{
    if(password.length >= 8)
    {
        return "";
    }
    return "A password should be 8 characters long\n";
}

function validatePasswordMatch(pwd, pwdRep)
{
    if(pwd === pwdRep)
    {
        return "";
    }
    return "The passwords that were entered do not match\n";
}

function validateMobNum(mob)
{
    if((/[0-9]/.test(mob)) && (mob.length == 11))
    {
        return "";
    }
    return "Mobile number must contain numbers and be 11 digits long\n";
}



function validateLoginForm()
{

}


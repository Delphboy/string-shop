/**
 * Call all the other validation methods and use their return values to create an error message
 * If an error message exists, display it and return FALSE
 * else return TRUE
 * @returns {boolean}
 */
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

/**
 * Take the email and confirmation email and check that they are the same
 * If they're different, return a message saying so
 * @param email
 * @param emailRep
 * @returns {*}
 */
function validateEmail(email, emailRep)
{
    if(email === emailRep)
    {
        return "";
    }
    return "The emails that were entered do not match\n";
}

/**
 * Take the password and check that it's over 8 characters
 * If the password is less than 8 characters, return a message saying so
 * @param password
 * @returns {*}
 */
function validatePasswordLength(password)
{
    if(password.length >= 8)
    {
        return "";
    }
    return "A password should be 8 characters long\n";
}

/**
 * Take the password and confirmation password and check that they are the same
 * If they're different, return a message saying so
 * @param pwd
 * @param pwdRep
 * @returns {*}
 */
function validatePasswordMatch(pwd, pwdRep)
{
    if(pwd === pwdRep)
    {
        return "";
    }
    return "The passwords that were entered do not match\n";
}

/**
 * Take the mobile number check that it is a string of numbers and that it has a length of 11
 * If the conditions aren't met, return a message saying so
 * @param mob
 * @returns {*}
 */
function validateMobNum(mob)
{
    if((/[0-9]/.test(mob)) && (mob.length == 11))
    {
        return "";
    }
    return "Mobile number must contain numbers and be 11 digits long\n";
}


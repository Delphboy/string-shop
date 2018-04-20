<?php
require_once 'Models/Login.php';
require_once 'Models/Captcha.php';

session_start();
$view = new stdClass();
$view->pageTitle = 'Sign In or Register';
$view->loginMsg = "";

//Check whether the login button has been pressed
if(isset($_POST['login']))
{
    $reg = new Login();
    $result = $reg->signIn(htmlentities($_POST['LoginEmail']), htmlentities($_POST['LoginPassword']));
    if($result == true)
    {
        header('Location: user.php');
    }
    else
    {
        $view->loginMsg = "<p class='label-danger'>Login Failed. Incorrect details</p>";
    }
}

//Check if the registration form has been submitted
if(isset($_POST['submit']))
{
    $reg = new Login();
    $cap = $_SESSION['captchaAns'];
    $firstName = htmlentities($_POST['RegistrationFirstName']);
    $surname = htmlentities($_POST['RegistrationSurname']);
    $email = htmlentities($_POST['RegistrationEmail']);
    $password = htmlentities($_POST['RegistrationPassword']);
    $address = htmlentities($_POST['RegistrationAddress']);
    $postcode = htmlentities($_POST['RegistrationPostcode']);
    $mobNum = htmlentities($_POST['RegistrationMobileNumber']);
    $capAns = htmlentities($_POST['RegistrationCaptchaAns']);

    if($email != htmlentities($_POST['RegistrationEmailConfirmation']))
    {
        $view->loginMsg .= "<p class='label-warning'>Different emails</p>";
    }

    if($password != htmlentities($_POST['RegistrationPasswordConfirmation']))
    {
        $view->loginMsg .= "<p class='label-warning'>Different passwords</p>";
    }

    if((int)$cap != (int)$capAns)
    {
        $view->loginMsg .= "<p class='label-warning'>Captcha Failed</p>";
    }

    if(strlen($view->loginMsg) <= 0)
    {
        $wasAccountMade = $reg->registerNewUser($firstName, $surname, $email, $password, $address, $postcode, $mobNum);
        if($wasAccountMade == true)
        {
            $view->loginMsg = "<p class='label-success'>Account successfully created.</p>";
        }
        else
        {
            $view->loginMsg .= "<p class='label-warning'>An account already exists for this email.</p>";
        }
    }
}

//Check conditions to display page
if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        header('Location: index.php');
    }
}
else
{
    //Load captcha just before view to prevent it being reloaded
    $cap = new Captcha();
    $view->captchaQuestion = $cap->getNextQuestion();
    require_once('Views/login.phtml');
}

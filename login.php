<?php
require_once 'Models/Login.php';
require_once 'Models/Captcha.php';

session_start();
$view = new stdClass();
$view->pageTitle = 'Sign In or Register';
$view->loginMsg = "";

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

if(isset($_POST['submit']))
{
    $reg = new Login();
    $cap = $_SESSION['captchaAns'];
    $firstName = htmlentities($_POST['RegistrationFirstName']);
    $surname = htmlentities($_POST['RegistrationSurname']);
    $email = htmlentities($_POST['RegistrationEmail']);
    $password = password_hash(htmlentities($_POST['RegistrationPassword']), PASSWORD_BCRYPT);
    $address = htmlentities($_POST['RegistrationAddress']);
    $postcode = htmlentities($_POST['RegistrationPostcode']);
    $mobNum = htmlentities($_POST['RegistrationMobileNumber']);
    $capAns = htmlentities($_POST['RegistrationCaptchaAns']);

    if((int)$cap != (int)$capAns)
    {

        $view->loginMsg .= "<p class='label-warning'>Captcha Failed</p>";
    }
    else
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

if(isset($_SESSION['isSignedIn']))
{
    if($_SESSION['isSignedIn'])
    {
        header('Location: user.php');
    }
}
else
{
    $cap = new Captcha();
    $view->captchaQuestion = $cap->getNextQuestion();
    require_once('Views/login.phtml');
}

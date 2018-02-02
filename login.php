<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Sign In or Register';

spl_autoload_register(function ($class)
{
    include 'Models/' . $class . '.php';
});

if(isset($_POST['login']))
{
    $reg = new Login();
    $result = $reg->signIn(htmlentities($_POST['LoginEmail']), htmlentities($_POST['LoginPassword']));
    if($result == true)
    {
        header('Location: user.php');
    }
}

if(isset($_POST['submit']))
{
    $reg = new Login();
    $firstName = htmlentities($_POST['RegistrationFirstName']);
    $surname = htmlentities($_POST['RegistrationSurname']);
    $email = htmlentities($_POST['RegistrationEmail']);
    $password = password_hash(htmlentities($_POST['RegistrationPassword']), PASSWORD_BCRYPT);
    $address = htmlentities($_POST['RegistrationAddress']);
    $postcode = htmlentities($_POST['RegistrationPostcode']);
    $mobNum = htmlentities($_POST['RegistrationMobileNumber']);

    $wasAccountMade = $reg->registerNewUser($firstName, $surname, $email, $password, $address, $postcode, $mobNum);

    if($wasAccountMade == true)
    {
        $view->wasAccountMade = "Account successfully created.";
    }
    else
    {
        $view->wasAccountMade = "An account already exists for this email.";
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
    require_once('Views/login.phtml');
}

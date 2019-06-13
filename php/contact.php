<?php
$array = array(
    "firstname" => "", "name" => "", "email" => "",
    "phone" => "", "message" => "", "firstnameError" => "",
    "nameError" => "", "emailError" => "", "phoneError" => "",
    "messageError" => "", "isSuccess" => false
);

$emailTo = "diopmbayejacques9@gmail.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";

    if (empty($array["firstname"])) {
        $array["firstnameError"] = "Je veux connaitre ton prénom !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Firstname: {$array["firstname"]}\n";
    }
    if (empty($array["name"])) {
        $array["nameError"] = "Tu oublie ton nom !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Name: {$array["name"]}\n";
    }
    if (!isEmail($array["email"])) {
        $array["emailError"] = "Veiller entrez un email valide !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Email: {$array["email"]}\n";
    }
    if (!isPhone($array["phone"])) {
        $array["phoneError"] = "Veiller entrez un numéro de téléphone valide !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Phone: {$array["phone"]}\n";
    }
    if (empty($array["message"])) {
        $array["messageError"] = "Pourquoi me contactez vous !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Message: {$array["message"]}\n";
    }
    if ($array["isSuccess"]) {
        $headers = "from: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-to: {$array["email"]}";
        mail($emailTo, "message from my site", $emailText, $headers);
    }

    echo json_encode($array);
}

function isPhone($isTel)
{
    return preg_match("/^[0-9 ]*$/", $isTel);
}

function isEmail($isMail)
{
    return filter_var($isMail, FILTER_VALIDATE_EMAIL);
}

function verifyInput($var)
{
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

?>
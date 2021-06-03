<?php

require_once '../includes/autoload.php';

$helper = new \Helper\Helper();

/**
 * Receiving fields via POST method and validate
 */

$arrayErrorMessage = [];
$arrayFields = [];

/**
 * name
 */
if (empty($_POST["name"])) {
    $errorMessage = "Name is required";
    array_push($arrayErrorMessage, $errorMessage);
} else {
    $name = $_POST["name"];
    array_push($arrayFields, $name);
}

/**
 * lastName
 */
if (empty($_POST["lastName"])) {
    $errorMessage = "Last name is required";
    array_push($arrayErrorMessage, $errorMessage);
} else {
    $lastName = $_POST['lastName'];
    array_push($arrayFields, $lastName);
}

/**
 * email
 */
if (empty($_POST["email"])) {
    $errorMessage = "E-mail is required";
    array_push($arrayErrorMessage, $errorMessage);

} else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errorMessage = "Invalid E-mail";
    array_push($arrayErrorMessage, $errorMessage);

} else {
    $email = $_POST["email"];
    array_push($arrayFields, $email);
}

/**
 * phoneNumber
 */
if (empty($_POST["phoneNumber"])) {
    $errorMessage = "Phone number is required";
    array_push($arrayErrorMessage, $errorMessage);

} else if (!\Helper\Helper::validatePhoneNumber($_POST['phoneNumber'])) {
    $errorMessage = "Invalid Phone number";
    array_push($arrayErrorMessage, $errorMessage);

} else {
    $phoneNumber = $_POST['phoneNumber'];
    array_push($arrayFields, $phoneNumber);
}

/**
 * login
 */
if (empty($_POST["login"])) {
    $errorMessage = "Login is required";
    array_push($arrayErrorMessage, $errorMessage);

} else {
    $login = $_POST['login'];
    array_push($arrayFields, $login);
}

/**
 * password
 */
if (empty($_POST["password"])) {
    $errorMessage = "Password is required";
    array_push($arrayErrorMessage, $errorMessage);

} else {
    $password = \Helper\Helper::hashPassword($_POST['password']);
    array_push($arrayFields, $password);
}

/**
 * check email or login already exist
 */
if (!empty($_POST['email']) && !empty($_POST['login'])) {

    if (\Helper\Helper::checkIfEmailOrLoginExists($_POST['email'], $_POST['login'])) {

        $errorMessage = "Email or Login already exists";
        array_push($arrayErrorMessage, $errorMessage);
    }
}

if (empty($arrayErrorMessage)) {

    $filePath = '../txt/registers.txt';

    if (
        file_exists($filePath) &&
        filesize($filePath) != 0
    ) {

        $registers = fopen($filePath, "r") or die("Unable to open file!");
        $readRegisters = fread($registers, filesize($filePath));

        $arrayRegisters = json_decode($readRegisters);

        array_push($arrayRegisters, $arrayFields);
        fclose($registers);

        $updateRegister = fopen($filePath, 'w') or die("Unable to open file!");
        fwrite($updateRegister, json_encode($arrayRegisters));
        fclose($updateRegister);

    } else {

        $registers = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($registers, json_encode([$arrayFields]));
        fclose($registers);

    }

    echo json_encode(['code'=> 200, 'msg'=> 'Registro salvo com sucesso']);
    exit;
}

echo json_encode(['code'=> 422, 'msg'=> $arrayErrorMessage]);

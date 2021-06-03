<?php

namespace Helper;

class Helper
{
    public static function validatePhoneNumber($phone) : bool {

        $filteredPhoneNumber = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phoneToVerify = str_replace("-", "", $filteredPhoneNumber);

        if (strlen($phoneToVerify) < 10 || strlen($phoneToVerify) > 11) {
            return false;
        } else {
            return true;
        }
    }

    public static function hashPassword($password) : string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        return $hash;
    }

    public static function checkIfEmailOrLoginExists($email, $login)
    {
        $path = '../txt/registers.txt';

        if (file_exists($path) && filesize($path) !== 0) {

            $registers = fopen($path, "r") or die("Unable to open file!");
            $readRegisters = fread($registers, filesize($path));

            $arrayRegisters = json_decode($readRegisters);

            foreach ($arrayRegisters as $key => $register) {

                foreach ($register as $item) {

                    if ($email === $item || $login === $item) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

}

<?php

function hashPassword($plainPassword){
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

function verifyPassword($plainPassword, $hashPassword){
    return password_verify ($plainPassword, $hashPassword);
}
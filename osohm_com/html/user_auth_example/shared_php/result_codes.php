<?php
/***********************************************************************
 * Website result codes.
 **********************************************************************/

// if we use an undefined constant.
const UNCAUGHT_ERROR                = 0;     

// general success result code.
const SUCCESS_NO_ERROR              = 1;

// general form validation codes.
const VALIDATON_REGISTER_EMPTY_FORM = 2;
const VALIDATION_LOGIN_EMPTY_FORM   = 3;
const VALIDATION_EMAIL_INVALID      = 4;
const VALIDATION_USERNAME_INVALID   = 5;
const VALIDATION_PASSWORD_INVALID   = 6;

// registration result codes.
const REGISTER_CANT_CONNECT         = 7;
const REGISTER_SEL_QUERY_ERROR      = 8;
const REGISTER_USER_EXISTS          = 9;
const REGISTER_INS_QUERY_ERROR      = 10;

// login result codes.    
const LOGIN_CANT_CONNECT            = 11;
const LOGIN_SEL_QUERY_ERROR         = 12;
const LOGIN_INVALID_USER_PASSWORD   = 13;

// login check codes.    
const CHECK_SESSION_NO_USER         = 14;

?>

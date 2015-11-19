<?php
/***********************************************************************
 * Website result codes.
 * @author Camilo Tejeiro   ,=,e 
 **********************************************************************/

    // if we use an undefined constant.
    const UNCAUGHT_ERROR                = 0;     

    // general success result code.
    const SUCCESS_NO_ERROR              = 1;

    // form validation codes.
    const VALIDATE_REGISTER_EMPTY_FORM  = 2;
    const VALIDATE_LOGIN_EMPTY_FORM     = 3;
    const VALIDATE_RESET_PWD_EMPTY_FORM = 4;

    // field validation codes.
    const VALIDATE_EMAIL_INVALID        = 5;
    const VALIDATE_USERNAME_INVALID     = 6;
    const VALIDATE_PASSWORD_INVALID     = 7;
    const VALIDATE_PASSWORD_NO_MATCH    = 8;

    // registration result codes.
    const REGISTER_DB_CANT_CONNECT      = 9;
    const REGISTER_DB_QUERY_ERROR       = 10;
    const REGISTER_DB_USER_EXISTS       = 11;
    const REGISTER_DB_INSERT_USER_ERROR = 12;

    // login result codes.    
    const LOGIN_DB_CANT_CONNECT         = 13;
    const LOGIN_DB_QUERY_ERROR          = 14;
    const LOGIN_DB_INVALID_USER_PASSWORD= 15;

    // login check codes.    
    const CHECK_SESSION_NO_USER         = 16;

    // logout result codes.
    const LOGOUT_ERROR                  = 17;

    // reset password result codes
    const RESET_PWD_DB_CANT_CONNECT     = 18;
    const RESET_PWD_DB_CANT_UPDATE      = 19;
    const RESET_PWD_DB_QUERY_ERROR      = 20;
    const RESET_PWD_DB_EMPTY_EMAIL      = 21;
    const RESET_PWD_DB_INVALID_USER     = 22;
    const RESET_PWD_MAIL_ERROR          = 23;
    
    // change password result codes.
    const CHANGE_PWD_DB_CANT_CONNECT    = 24;
    const CHANGE_PWD_DB_QUERY_ERROR     = 25;
    const CHANGE_PWD_DB_INVALID_PASSWORD= 26;
    const CHANGE_PWD_DB_CANT_UPDATE     = 27;
    
?>

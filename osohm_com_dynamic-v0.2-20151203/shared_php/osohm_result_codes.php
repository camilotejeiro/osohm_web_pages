<?php
/***********************************************************************
 * Osohm Wesbite Error codes.
 * Simple result codes we use for different purposes in our platform.
 * These are all compile time constants (not run-time constants)
 ***********************************************************************/

/*
 * Registration result codes
 */
const REGISTRATION_SUCCESSFUL =     0;
const REGISTRATION_EMPTY_DATA =      1;
const REGISTRATION_FOREIGN_FORM =     2;

/*
 * login result codes
 */
const LOGIN_SUCCESSFUL             =     0;
const LOGIN_EMPTY_DATA            =      3;
const LOGIN_USER_NOT_FOUND         =     4;
const LOGIN_WRONG_USER_PASSWORD    =     5;

/*
 * logout result codes
 */
const LOGOUT_SUCCESSFUL     = 0;
const LOGOUT_IDOUT_ERROR    = 6;
const LOGOUT_USEROUT_ERROR    = 7;

/*
 * checkLogin result codes
 */
const CHECK_LOGIN_SESSION_FOUND         = 0;
const CHECK_LOGIN_EMPTY_COOKIE             = 8;
const CHECK_LOGIN_USER_NOT_FOUND         = 9;
const CHECK_LOGIN_WRONG_USER_PASSWORD     = 10;      

?>

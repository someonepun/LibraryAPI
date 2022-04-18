<?php
    //constant for database connection
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_NAME','ishelf');

    //constant for create operation
    define('USER_CREATED', 101);
    define('USER_EXISTS', 102);
    define('USER_FAILURE',103);

    //user login possibility
    define ('USER_AUTHENTICATED', 201);
    define ('USER_NOT_FOUND', 202);
    define('USER_PASSWORD_DO_NOT_MATCH', 203);

    //for password change messages
    define('PASSWORD_CHANGED', 301);
    define('PASSWORD_DO_NOT_MATCH', 302);
    define('PASSWORD_NOT_CHANGED', 303);

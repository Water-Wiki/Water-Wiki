<?php 

ini_set('session.use_only_cookies', 1); // setting equal to true (0 means false)
ini_set('session.use_strict_mode', 1); // the website only use session_id BY the SERVER and MANDATORY when session is active

session_set_cookie_params([
    // after a certain amount of time has passed, we should destroy the cookie
    'lifetime' => 1800, // 30 min in seconds
    'domain' => 'localhost', // example.com if we have a server
    'path' => '/', // any subpages
    'secure' => true, // only using https connection and not http connection
    'httponly' => true // restrict any script access on the client
]);

// everything above HAS TO BE set before starting a session for security purpose
session_start();

if (!isset($_SESSION['last_regeneration'])) { // check if session has already started

    session_regenerate_id(true); // turn the current session id into a better one
    $_SESSION['last_regeneration'] = time();
} else {

    $interval = 60 * 30; // 30 minutes

    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regernation'] = time();
    }
}

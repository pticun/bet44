<?php

function possible_games(){

}

function hasSessionTimedout()
{
    $timed_out = false;
    $time = $_SERVER['REQUEST_TIME'];

    /**
     * for a 30 minute timeout, specified in seconds
     */
    $timeout_duration = 1800;

    /**
     * Here we look for the user's LAST_ACTIVITY timestamp. If
     * it's set and indicates our $timeout_duration has passed,
     * blow away any previous $_SESSION data and start a new one.
     */
    if (isset($_SESSION['LAST_ACTIVITY']) &&
        ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();
        session_destroy();
        session_start();

        $timed_out = true;
    } else {
        $time = false;
    }

    /**
     * Finally, update LAST_ACTIVITY so that our timeout
     * is based on it and not the user's login time.
     */
    $_SESSION['LAST_ACTIVITY'] = $time;

    return $timed_out;
}
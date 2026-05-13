<?php
/**
 * PHPUnit Test Bootstrap
 */

if (!defined('TB_PREF')) {
    define('TB_PREF', 'fa_');
}
if (!defined('INPUT_COOKIE')) {
    define('INPUT_COOKIE', '');
}

function db_query($sql) {
    return true;
}

function db_fetch_assoc($result) {
    return null;
}

function db_insert_id() {
    return 1;
}

function db_escape($value) {
    return "'" . addslashes($value) . "'";
}
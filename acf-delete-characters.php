<?php
/*
Plugin Name: ACF-delete-characters
Description: Удаление символов из title. Для работы необходим плагин ACF
Version: 1.0
Author: Snigur Dmitry
*/


require_once( dirname( __FILE__ ) . '/acfDeleteCharactersCLass.php' );

add_action( 'init', function(){
    new acfDeleteCharactersCLass( array(
        'debug' => true
    ) );
});










?>
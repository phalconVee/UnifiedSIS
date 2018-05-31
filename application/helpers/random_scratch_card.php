<?php
/**
 * Created by PhpStorm.
 * User: Phalcon Vee
 * Date: 9/8/17
 * Time: 3:34 PM
 */

if ( ! function_exists('get_random_character'))
{

    function get_random_character($length = 10, $use_upper_case=true, $include_numbers=true, $include_special_chars=false)
    {
        $selection = 'AEUOYIBCDFGHJKLMNPGRSTVWXZ';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $characters = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $characters .=  $current_letter;
        }

        return $characters;
    }

}
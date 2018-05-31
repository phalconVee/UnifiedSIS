<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

if ( ! function_exists('accountant_username_validation'))
{
    function accountant_username_validation($username){
        $ci=& get_instance();
        $num_rows = 0;
        $user_array = array('accountant');
        $size = sizeof($user_array);

        for($i = 0; $i < $size; $i++){
            $ci->db->where('username', $username);
            $num_rows = $ci->db->get($user_array[$i])->num_rows();
            if($num_rows > 0){
                return 0;
            }
        }
        return 1;
    }
}

if ( ! function_exists('accountant_username_validation_for_edit')){
    function accountant_username_validation_for_edit($username, $id, $type){
        $num_rows = 0;
        $ci=& get_instance();
        $user_array = array('accountant');
        $size = sizeof($user_array);
        for($i = 0; $i < $size; $i++){
            if($type == $user_array[$i]){
                $ci->db->where_not_in($user_array[$i].'_id', $id);
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
            else{
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
        }
        return 1;
    }
}


if ( ! function_exists('parent_username_validation'))
{
    function parent_username_validation($username){
        $ci=& get_instance();
        $num_rows = 0;
        $user_array = array('parent');
        $size = sizeof($user_array);

        for($i = 0; $i < $size; $i++){
            $ci->db->where('username', $username);
            $num_rows = $ci->db->get($user_array[$i])->num_rows();
            if($num_rows > 0){
                return 0;
            }
        }
        return 1;
    }
}

if ( ! function_exists('parent_username_validation_for_edit')){
    function parent_username_validation_for_edit($username, $id, $type){
        $num_rows = 0;
        $ci=& get_instance();
        $user_array = array('parent');
        $size = sizeof($user_array);
        for($i = 0; $i < $size; $i++){
            if($type == $user_array[$i]){
                $ci->db->where_not_in($user_array[$i].'_id', $id);
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
            else{
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
        }
        return 1;
    }
}


if ( ! function_exists('teacher_username_validation'))
{
    function teacher_username_validation($username){
        $ci=& get_instance();
        $num_rows = 0;
        $user_array = array('teacher');
        $size = sizeof($user_array);

        for($i = 0; $i < $size; $i++){
            $ci->db->where('username', $username);
            $num_rows = $ci->db->get($user_array[$i])->num_rows();
            if($num_rows > 0){
                return 0;
            }
        }
        return 1;
    }
}

if ( ! function_exists('teacher_username_validation_for_edit')){
    function teacher_username_validation_for_edit($username, $id, $type){
        $num_rows = 0;
        $ci=& get_instance();
        $user_array = array('teacher');
        $size = sizeof($user_array);
        for($i = 0; $i < $size; $i++){
            if($type == $user_array[$i]){
                $ci->db->where_not_in($user_array[$i].'_id', $id);
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
            else{
                $ci->db->where('username', $username);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
        }
        return 1;
    }
}

if ( ! function_exists('librarian_username_validation'))
{
    function librarian_username_validation($email){
        $ci=& get_instance();
        $num_rows = 0;
        $user_array = array('librarian');
        $size = sizeof($user_array);

        for($i = 0; $i < $size; $i++){
            $ci->db->where('username', $email);
            $num_rows = $ci->db->get($user_array[$i])->num_rows();
            if($num_rows > 0){
                return 0;
            }
        }
        return 1;
    }
}

if ( ! function_exists('librarian_username_validation_for_edit')){
    function librarian_username_validation_for_edit($email, $id, $type){
        $num_rows = 0;
        $ci=& get_instance();
        $user_array = array('librarian');
        $size = sizeof($user_array);
        for($i = 0; $i < $size; $i++){
            if($type == $user_array[$i]){
                $ci->db->where_not_in($user_array[$i].'_id', $id);
                $ci->db->where('username', $email);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
            else{
                $ci->db->where('email', $email);
                $num_rows = $ci->db->get($user_array[$i])->num_rows();
                if($num_rows > 0){
                    return 0;
                }
            }
        }
        return 1;
    }
}

if ( ! function_exists('email_validation'))
{
	function email_validation($email){
		$ci=& get_instance();
		$num_rows = 0;
		$user_array = array('admin', 'teacher', 'parent', 'student', 'accountant', 'librarian');
		$size = sizeof($user_array);

		for($i = 0; $i < $size; $i++){
			$ci->db->where('email', $email);
			$num_rows = $ci->db->get($user_array[$i])->num_rows();
			if($num_rows > 0){
				return 0;
			}
		}
		return 1;
	}
}

if ( ! function_exists('email_validation_for_edit')){
	function email_validation_for_edit($email, $id, $type){
		$num_rows = 0;
		$ci=& get_instance();
		$user_array = array('admin', 'teacher', 'parent', 'student', 'accountant', 'librarian');
		$size = sizeof($user_array);
		for($i = 0; $i < $size; $i++){
			if($type == $user_array[$i]){
				$ci->db->where_not_in($user_array[$i].'_id', $id);
				$ci->db->where('email', $email);
				$num_rows = $ci->db->get($user_array[$i])->num_rows();
				if($num_rows > 0){
					return 0;
				}
			}
			else{
				$ci->db->where('email', $email);
				$num_rows = $ci->db->get($user_array[$i])->num_rows();
				if($num_rows > 0){
					return 0;
				}
			}
		}
		return 1;
	}
}

// Section duplication on create
if ( ! function_exists('duplication_of_section_on_create')){
	function duplication_of_section_on_create($class_id, $section_name){
		$ci=& get_instance();
		$num_rows = 0;
		$data = array(
		'class_id' => $class_id,
		'name' => $section_name
		);
		$ci->db->where($data);
		$num_rows = $ci->db->get('section')->num_rows();
		if($num_rows == 0){
			return 1;
		}
		else if($num_rows > 1){
			return 0;
		}
	}
}
// section duplication on edit
if ( ! function_exists('duplication_of_section_on_edit')){
	function duplication_of_section_on_edit($section_id, $class_id, $section_name){
		$ci=& get_instance();
		$num_rows = 0;
		$data = array(
		'class_id' => $class_id,
		'name' => $section_name
		);
		$ci->db->where_not_in('section_id', $section_id);
		$ci->db->where($data);
		$num_rows = $ci->db->get('section')->num_rows();
		if($num_rows == 0){
			return 1;
		}
		else if($num_rows > 1){
			return 0;
		}
	}
}

// class routine duplication on create
if ( ! function_exists('duplication_of_class_routine_on_create')){
	function duplication_of_class_routine_on_create($data){
		$ci=& get_instance();
		$num_rows = 0;
		$ci->db->where($data);
		$num_rows = $ci->db->get('class_routine')->num_rows();
		if($num_rows == 0){
			return 1;
		}
		else if($num_rows > 1){
			return 0;
		}
	}
}

// class routine duplication on edit
if ( ! function_exists('duplication_of_class_routine_on_edit')){
	function duplication_of_class_routine_on_edit($data, $class_routine_id){
		$ci=& get_instance();
		$num_rows = 0;
		$ci->db->where_not_in('class_routine_id', $class_routine_id);
		$ci->db->where($data);
		$num_rows = $ci->db->get('class_routine')->num_rows();
		if($num_rows == 0){
			return 1;
		}
		else if($num_rows > 1){
			return 0;
		}
	}
}

// ------------------------------------------------------------------------
/* End of file User_validation.php */
/* Location: ./system/helpers/User_validation.php */

<?php
/**
 * Base Config Url
//--------------------------------------------

/**
 * Base Css Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_css") ) {
	function base_css() {
		$CI	=& get_instance();
		return $CI->config->item('base_css');
	}
}

/**
 * Base Image Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_img") ) {
	function base_img() {
		$CI	=& get_instance();
		return $CI->config->item('base_img');
	}
}

/**
 * Base Javascript Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_js") ) {
	function base_js() {
		$CI	=& get_instance();
		return $CI->config->item('base_js');
	}
}

/**
 * Base API Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_api") ) {
	function base_api() {
		$CI	=& get_instance();
		return $CI->config->item('base_api');
	}
}

/**
 * Base API Payment Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_api_payment") ) {
	function base_api_payment() {
		$CI	=& get_instance();
		return $CI->config->item('base_api_payment');
	}
}

/**
 * Base Third API Email Validate Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_third_api_emailvalidate") ) {
	function base_third_api_emailvalidate() {
		$CI	=& get_instance();
		return $CI->config->item('base_third_api_emailvalidate');
	}
}

/**
 * Base Third API Forget password Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_third_api_emailforget") ) {
	function base_third_api_emailforget() {
		$CI	=& get_instance();
		return $CI->config->item('base_third_api_emailforget');
	}
}

?>
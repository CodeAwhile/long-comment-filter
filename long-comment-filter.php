<?php
/*

Plugin Name: Long Comment Filter
Plugin URI: http://www.itsananderson.com/plugins/long-comment-filter
Description: Automatically Spams or Deletes comments that don't meet a specified length requirement.
Author: Will Anderson
Version: 2.2
Author URI: http://www.itsananderson.com/
*/

class Long_Comment_Filter {

    const VERSION = '2.2';

    /**
     * Function for initializing this class
     * @static
     * @return void
     */
    public static function start() {
        add_filter( 'preprocess_comment',array( __CLASS__, 'filter_long_comments' ) );
        add_action( 'get_header', array( __CLASS__, 'maybe_add_js_check' ) );
    }

    /*
     * Filter applied to comments.
     * Removes comments that don't meet a specific length requirement.
     */
    public static function filter_long_comments($comment) {
        if ( self::filter_comment_check($comment) ) {
            Long_Comment_Filter_Settings::increment_filtered_comment_count();
            self::filter_long_comment($comment);
        }
        return $comment;
    }

    /*
     * Check whether the comment should be filtered.
     */
    public static function filter_comment_check($comment) {
        // Only filter registered users if that option is enabled
        if ( $comment['user_ID'] && !Long_Comment_Filter_Settings::get_filter_users() ) return false;
        if ( $comment['comment_type'] ) return false; // don't filter trackbacks
        $comment_content = preg_replace('/\s+/', ' ', $comment['comment_content']);
        $filter_type = Long_Comment_Filter_Settings::get_filter_type();
        if ( 'words' == $filter_type ) {
            $words = explode(' ', $comment_content);
            return count($words) < Long_Comment_Filter_Settings::get_max_count();
        }
        if ( 'characters' == $filter_type ) {
            return strlen($comment_content) < Long_Comment_Filter_Settings::get_max_count();
        }
        return false;
    }

    /*
     * At the end of the request, remove the comment.
     */
    public static function filter_long_comment() {

        // Leaving room for more actions
        switch ( Long_Comment_Filter_Settings::get_default_action() ){
            case 'delete':
                $type = Long_Comment_Filter_Settings::get_filter_type();
                $length = Long_Comment_Filter_Settings::get_max_count();
                $message = Long_Comment_Filter_Settings::get_long_comment_message();
                $message = str_replace('%type%', $type, $message);
                $message = str_replace('%length%', $length, $message);
                wp_die($message);
            case 'spam':
            default: // default to spam
                add_filter('pre_comment_approved', create_function('$a', 'return \'spam\';'));
        }

    }

    /*
     * If JavaScript checking is enabled, queue the script and add the variable settings via wp_localize_script
     */
    public static function maybe_add_js_check(){
        if ( Long_Comment_Filter_Settings::get_js_check() == 'on' &&
             ( !is_user_logged_in() || Long_Comment_Filter_Settings::get_filter_users() == 'on' ) ) {
            $data = array(
                'filter_type' => Long_Comment_Filter_Settings::get_filter_type(),
                'max_count' => Long_Comment_Filter_Settings::get_max_count(),
                'filter_message' => preg_replace('/[\r\n]+/', '\r\n', addslashes( Long_Comment_Filter_Settings::get_long_comment_message() ) )
            );
            wp_enqueue_script( 'long-comment-filter', plugins_url( 'js/long-comment-filter-frontend.js', __FILE__ ),
                               array( 'jquery', 'jquery-form' ), self::VERSION );
            wp_localize_script( 'long-comment-filter', 'long_comment_settings', $data );
        }
    }

    /**
     * Utility function for showing a plugin view
     * @param $view
     * @param array $args
     * @return void
     */
    public static function show_view( $view, $args = array() ) {
        $view_path = plugin_dir_path( __FILE__ ) . "views/$view.php";
        if ( file_exists( $view_path ) ) {
            extract( $args );
            include $view_path;
        } else {
            echo "View '$view' does not exist";
        }
    }
}

include plugin_dir_path( __FILE__ ) . 'classes/long-comment-filter-settings.php';

Long_Comment_Filter::start();
Long_Comment_Filter_Settings::start();

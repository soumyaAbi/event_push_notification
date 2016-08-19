<?php

    /**
    * Plugin Name: Push Notification
    * Description: Push Notification.
    * Version: 1.0
    * Author: Jay Krishnan G
    */

class Push_Notification
{
    function __construct()
    {
        add_action('publish_event', 'Push_Notification::android_push_notification');
        add_action('publish_event', 'Push_Notification::iphone_push_notification');
    }

    function android_push_notification($post_ID)
    {
        $post_status = get_post_status();
        
        if($post_status == 'auto-draft' || $post_status == 'draft')
        {
            ignore_user_abort();

            $postid = get_the_ID();

            $arg1 = escapeshellarg($postid);

            $title = get_the_title($postid);

            $arg2 = escapeshellarg($title);

            $phpPath          = "/usr/bin/php";
            //$phpPath         = "php";

            $dir_path        = realpath(ABSPATH . '/..');
            $filePath        = $dir_path . "/app/push_notification/android_push_notification.php" ;

            //check if server machine is windows or linux
            if ( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' )
            {
                $WshShell         = new COM( "WScript.Shell" );
                $WshShell->Run( "$phpPath $filePath $arg1 $arg2", 0 ,false );
            }
            else
            {
                exec( "$phpPath $filePath $arg1 $arg2 > /dev/null 2>&1 &" );
            }
        }
    }

    /**
     * Send Push notifications
     * @param array $data
     *
     * @return array
     */
    function iphone_push_notification()
    {
        $post_status = get_post_status();

        if($post_status == 'auto-draft' || $post_status == 'draft')
        {
            //prevent user abort
            ignore_user_abort();

            $postid = get_the_ID();

            $arg1 = escapeshellarg($postid);

            $title = get_the_title($postid);

            $arg2 = escapeshellarg($title);

            //$phpPath         = "D:\wamp\bin\php\php5.4.16\php.exe";
            $phpPath         = "/usr/bin/php";
            
            $dir_path        = realpath(ABSPATH . '/..');
            $filePath        = $dir_path . "/app/push_notification/ios_push_notification.php" ;

            //check if server machine is windows or linux
            if ( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' )
            {
                $WshShell         = new COM( "WScript.Shell" );
                $WshShell->Run( "$phpPath $filePath $arg1 $arg2", 0 ,false );
            }
            else
            {
                exec( "$phpPath $filePath $arg1 $arg2 > /dev/null 2>&1 &" );
            }
        }
    }
}

$push_notification = new Push_Notification;

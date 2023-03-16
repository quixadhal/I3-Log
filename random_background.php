<?php
require_once 'site_global.php';
require_once 'log_navigation.php';

$BACKGROUND_URL         = "$URL_HOME/gfx/one_black_pixel.png";
$BACKGROUND_DIR         = "$FILE_HOME/gfx/wallpaper/";
$SPECIAL_DIR            = "$FILE_HOME/gfx/wallpaper/$month_day/";
$BORING_DIR             = "$FILE_HOME/gfx/wallpaper/sfw/";
$BACKGROUND_DIR_URL     = "$URL_HOME/gfx/wallpaper";
$SPECIAL_DIR_URL        = "$URL_HOME/gfx/wallpaper/$month_day";
$BORING_DIR_URL         = "$URL_HOME/gfx/wallpaper/sfw";
$BACKGROUND_FILE        = "$FILE_HOME/random_background_css.php";
$BACKGROUND_TIME        = filemtime($BACKGROUND_FILE);
$BACKGROUND_CSS         = "$URL_HOME/random_background_css.php?version=$BACKGROUND_TIME";
$BACKGROUND_JS          = "$URL_HOME/random_background_js.php";
$background_image_list  = array();
$special_image_list     = array();
$safe_special_image_list = array();
$boring_image_list      = array();
$today_dir_exists       = false;

function random_background($dir) {
    global $background_image_list;
    global $special_image_list;
    global $safe_special_image_list;
    global $boring_image_list;
    global $month_day;
    global $today_dir_exists;
    $old_dir = getcwd();
    $today_dir = "$dir/$month_day";
    $boring_dir = "$dir/sfw";

    chdir($boring_dir);
    $jpg_list = glob("*.jpg");
    $png_list = glob("*.png");
    $boring_image_list = array_merge($jpg_list, $png_list);
    // This lets us be SFW, unless Today overrides it.
    $pick = array_rand($boring_image_list);

    chdir($dir);
    $jpg_list = glob("*.jpg");
    $png_list = glob("*.png");
    $background_image_list = array_merge($jpg_list, $png_list);
    //$pick = array_rand($background_image_list);

    if(is_dir($today_dir)) {
        // This allows us to create special subdirectories
        // which will override the normal set for a specific
        // date each year (mm-dd format), so we can have
        // holiday specific images.
        $today_dir_exists = true;
        chdir($today_dir);
        $jpg_list = glob("*.jpg");
        $png_list = glob("*.png");
        $special_image_list = array_merge($jpg_list, $png_list);
        // Now we keep all the special stuff in ../kawaii/
        // so we should be able to filter them out by using readlink()
        // to check the eventual path, which should be either one or two
        // symlink levels away.
        foreach ($special_image_list as $i) {
            if(is_link($i)) {
                // Let's see...
                $t = readlink($i);
                if(is_link($t)) {
                    // OK, this probably pointed to ../foo which may
                    // then point to kawaii/blah...
                    $t2 = readlink($t);
                    if(strpos($t2, "kawaii/") !== false) {
                        // NSFW
                    } else {
                        $safe_special_image_list[] = $i;
                    }
                } else {
                    // Good, this points to a file (or is broken)
                    // If the path has kawaii in it, skip it.
                    if(strpos($t, "kawaii/") !== false) {
                        // NSFW
                    } else {
                        $safe_special_image_list[] = $i;
                    }
                }
            } else {
                $safe_special_image_list[] = $i;
            }
        }
        $pick = array_rand($special_image_list);
    }
    chdir($old_dir);
    return $background_image_list[$pick];
}

// We don't USE the result here, but we populate the array by calling it.
// That, in turn, lets us push that array contents into javascript later.
random_background($BACKGROUND_DIR);
?>

<?php
date_default_timezone_set("America/Los_Angeles");

function is_local_ip() {
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
    if($visitor_ip == '104.156.100.167') // Hard coded DNS entry
        return 1;
    $varr = explode(".", $visitor_ip);
    if($varr[0] == "192" && $varr[1] == "168")
        return 1;
    return 0;
}

function https() {
    return isset($_SERVER['HTTPS']) ? 'https' : 'http';
}

function address() {
    $server_addr = $_SERVER['SERVER_ADDR'];
    return 'wileymud.themud.org';

    if($server_addr == '192.168.0.12') {
        # production
        return 'wileymud.themud.org';
    } else {
        # random test site
        return $server_addr;
    }
}

function pcmd($command) {
    $data = "";
    $fp = popen("$command", "r");
    do {
        $data .= fread($fp, 8192);
    } while(!feof($fp));
    pclose($fp);
    echo $data;
}
function get_browser_info() {
    // This is to allow strpos() to never return 0 on a success
    $ua = " " . strtolower($_SERVER['HTTP_USER_AGENT']);
    $os = 'windows';
    $browser = 'bot';
    $result = array();

    if(preg_match('/linux/i', $ua)) $os = 'linux';
    elseif(preg_match('/macintosh|mac\s+os\s+x/i', $ua)) $os = 'mac';
    elseif(preg_match('/windows|win32/i', $ua)) $os = 'windows';

    if(strpos($ua, 'opera') || strpos($ua, 'opr/')) $browser = 'opera';
    elseif(strpos($ua, 'edge')) $browser = 'edge';
    elseif(strpos($ua, 'chrome')) $browser = 'chrome';
    elseif(strpos($ua, 'safari')) $browser = 'safari';
    elseif(strpos($ua, 'firefox')) $browser = 'firefox';
    elseif(strpos($ua, 'msie') || strpos($ua, 'trident/7')) $browser = 'ie';

    $result["os"] = $os;
    $result["browser"] = $browser;
    return $result;
}

$browser_info = get_browser_info();
if(($browser_info["os"] == "bot")) {
    header('Location: https://www.youtube.com/watch?v=E_R9EaeRrWg', true, 302);
    exit();
}

$isLocal                = false;
if(is_local_ip()) {
    $isLocal = true;
}

$URL_HOME                   = https() . "://" . address() . "/log";
$FILE_HOME                  = "/home/www/log";

$JQ                         = "$URL_HOME/inc/jquery-3.7.1.min.js";
$JQUI_CSS                   = "$URL_HOME/inc/jquery-ui-1.12.1.custom/jquery-ui.min.css";
$JQUI_THEME                 = "$URL_HOME/inc/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css";
$JQUI                       = "$URL_HOME/inc/jquery-ui-1.12.1.custom/jquery-ui.min.js";
$JSCOOKIE                   = "$URL_HOME/inc/js.cookie.min.js";
$JSRANDOM                   = "$URL_HOME/inc/js.random.js";
$JSMD5                      = "$URL_HOME/inc/js.md5.js";
$MOMENT                     = "$URL_HOME/inc/moment/moment-with-locales.min.js";
$MOMENT_TZ                  = "$URL_HOME/inc/moment/moment-timezone-with-data.min.js";
$LIGHTBOX_JS                = "$URL_HOME/inc/lightbox/lightbox.min.js";
$LIGHTBOX_CSS               = "$URL_HOME/inc/lightbox/lightbox.min.css";

$SITE_GLOBAL_FILE           = "$FILE_HOME/site_global_css.php";
$SITE_GLOBAL_TIME           = filemtime($SITE_GLOBAL_FILE);
$SITE_GLOBAL_CSS            = "$URL_HOME/site_global_css.php?version=$SITE_GLOBAL_TIME";
$SITE_GLOBAL_JS             = "$URL_HOME/site_global_js.php";

$BGCOLOR                    = "black";
$TEXT                       = "#d0d0d0";
$UNVISITED                  = "#ffffbf";
$VISITED                    = "#ffa040";
$DELETED                    = "#ff0000";
$EVEN                       = "rgba(31,31,31,0.7)";
$ODD                        = "rgba(0,0,0,0.7)";
$INPUT                      = "#d0d0d0";
$INPUT_BORDER               = "#101010";
$INPUT_BACKGROUND           = "#101010";
$SELECTED_INPUT             = "#f0f0f0";
$SELECTED_INPUT_BORDER      = "#101010";
$SELECTED_INPUT_BACKGROUND  = "#303030";


$SCALE                      = 1.0;      // An easy way to adjust the overall size of everything.
$ICON_BASE                  = 64;
$FONT_BASE                  = 14;   // 24pt 39px, 18pt 30px, 14pt 24px, 10pt 17px, 1.7 seems close

$ICON_SIZE                  = sprintf("%dpx", (int)($ICON_BASE * $SCALE));
$SMALL_ICON_SIZE            = sprintf("%dpx", (int)($ICON_BASE * $SCALE * 0.75));
$FONT_SIZE                  = sprintf("%dpt", (int)($FONT_BASE * $SCALE));
$SMALL_FONT_SIZE            = sprintf("%dpt", (int)($FONT_BASE * $SCALE * 0.90));
$TINY_FONT_SIZE             = sprintf("%dpt", (int)($FONT_BASE * $SCALE * 0.70));
$BIG_FONT_SIZE              = sprintf("%dpt", (int)($FONT_BASE * $SCALE * 1.20));

$MUDLIST_JSON               = "$FILE_HOME/data/mudlist.json";
$mudlist_text               = file_get_contents($MUDLIST_JSON);
$mudlist                    = json_decode($mudlist_text, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);
$MSSP_MUDLIST_JSON          = "$FILE_HOME/data/mssp_mudlist.json";
//$mssp_mudlist_text          = file_get_contents($MSSP_MUDLIST_JSON);
//$mssp_mudlist               = json_decode($mssp_mudlist_text, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

$WILEY_BUILD_NUMBER         = $mudlist["version"]["build"];
$WILEY_BUILD_DATE           = $mudlist["version"]["date"];
$WILEY_TIME                 = $mudlist["time"];
$WILEY_BANNER_ICON          = "$URL_HOME/gfx/wileymud3.png";
$WILEY_BANNER_WIDTH         = 334;
$WILEY_BANNER_HEIGHT        = sprintf("%dpx", (int)($ICON_BASE * $SCALE));
//$WILEY_BANNER_HEIGHT      = 48;
$WILEY_URL                  = "telnet://" . address() . ":3000";
$WILEY_IP                   = address();
$WILEY_PORT                 = 3000;

$NOT_AVAILABLE_ICON         = "$URL_HOME/gfx/NA.png";
$ONE_PIXEL_ICON             = "$URL_HOME/gfx/one_black_pixel.png";

$LOG_PAGE_FILE              = "$FILE_HOME/log_page_css.php";
$LOG_PAGE_TIME              = filemtime($LOG_PAGE_FILE);
$LOG_PAGE_CSS               = "$URL_HOME/log_page_css.php?version=$LOG_PAGE_TIME";
$LOG_PAGE_JS                = "$URL_HOME/log_page_js.php";
$VISITOR_IP                 = $_SERVER['REMOTE_ADDR'];

$DOWNLOAD_URL               = "$URL_HOME/data/i3log.sql.xz";
$VM_URL                     = "$URL_HOME/../stuff/WileyMUD/";

$NOBODY_CARES               = true;
$FUNDME_CLASS               = "gfm-embed sticky-corner";
$FUNDME_DATA_URL            = "https://www.gofundme.com/f/the-intermud-log-page/widget/large";
$FUNDME_SRC_URL             = "https://www.gofundme.com/static/js/embed.js";
// https://gofund.me/8ac3cf9d

?>

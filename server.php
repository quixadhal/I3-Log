<?php 
$time_start = microtime(true);
require_once 'site_global.php';
require_once 'page_source.php';
require_once 'random_background.php';
require_once 'navbar.php';

$SERVER_CASE            = "$URL_HOME/gfx/server_case.png";
$SERVER_GUTS            = "$URL_HOME/gfx/server_guts.jpg";

$SPEEDTEST_WINDOWS_FILE = "$FILE_HOME/data/speedtest_windows.json";
$SPEEDTEST_LINUX_FILE   = "$FILE_HOME/data/speedtest_linux.json";
$SPEEDTEST_AVG_FILE     = "$FILE_HOME/data/speedtest_avg.json";

$SPEEDTEST_HEIGHT_BASE  = 200;
$SPEEDTEST_WIDTH_BASE   = 375;
$SPEEDTEST_HEIGHT       = sprintf("%dpx", (int)($SPEEDTEST_HEIGHT_BASE * $SCALE));
$SPEEDTEST_WIDTH        = sprintf("%dpx", (int)($SPEEDTEST_WIDTH_BASE * $SCALE));

$KELLY_MTR              = "$FILE_HOME/data/kelly.mtr";
$DALET_MTR              = "$FILE_HOME/data/dalet.mtr";
$DISK_SMART             = "$FILE_HOME/data/disk.smart";

$PG_DB      = "speedtest";
$PG_USER    = "wiley";
$PG_PASS    = "tardis69";
$PG_CHARSET = "en_US.UTF-8";

function db_connect() {
    global $PG_DB;
    global $PG_USER;
    global $PG_PASS;
    global $PG_CHARSET;

    $db = null;
    try {
        $db = new PDO( "pgsql:dbname=$PG_DB;user=$PG_USER;password=$PG_PASS", null, null, array(
            //PDO::ATTR_PERSISTENT        => true, 
            PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES  => false,
        ));
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    /*
    try {
        $sth = $db->prepare("SET CLIENT_ENCODING TO 'UTF8';");
        $sth->execute();
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
     */
    return $db;
}

$speedtest_window_text = file_get_contents($SPEEDTEST_WINDOWS_FILE);
$speedtest_windows = json_decode($speedtest_window_text, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);
if(!array_key_exists('result', $speedtest_windows)) {
    $speedtest_windows["unix_timestamp"] = time();
    $speedtest_windows["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", time());
    $speedtest_windows["speedtest_current"] = $NOT_AVAILABLE_ICON;
    $sql = "
            SELECT  extract(epoch FROM local)::integer AS unix_timestamp,
                    result_url,
                    internal_ip, external_ip,
                    name, host,
                    ping, download, upload
              FROM speedtest
             WHERE NOT wifi
          ORDER BY local DESC
             LIMIT 1
    ";
    $db = db_connect();
    $sth = $db->prepare($sql);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $sth->fetch()) {
        $speedtest_windows["unix_timestamp"] = $row["unix_timestamp"];
        $speedtest_windows["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", $speedtest_windows["unix_timestamp"]);
        $speedtest_windows["speedtest_current"] = $row["result_url"] . ".png";
        $speedtest_windows["interface"]["internalIp"] = $row["internal_ip"];
        $speedtest_windows["interface"]["name"] = "i219v"; // Windows doesn't report this, so hardcoded.
        $speedtest_windows["server"]["name"] = $row["name"];
        $speedtest_windows["server"]["host"] = $row["host"];
        $speedtest_windows["ping"]["latency"] = $row["ping"];
        $speedtest_windows["download"]["bandwidth"] = ($row["download"] * 1000000.0) / 8.0;
        $speedtest_windows["upload"]["bandwidth"] = ($row["upload"] * 1000000.0) / 8.0;
    }
    $db = null;
} else {
    $speedtest_windows["unix_timestamp"] = strtotime($speedtest_windows["timestamp"]);
    $speedtest_windows["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", $speedtest_windows["unix_timestamp"]);
    $speedtest_windows["speedtest_current"] = $speedtest_windows["result"]["url"] . ".png";
    $speedtest_windows["interface"]["name"] = "i219v";  // Windows doesn't report this, so hardcoded.
}

$speedtest_linux_text = file_get_contents($SPEEDTEST_LINUX_FILE);
$speedtest_linux = json_decode($speedtest_linux_text, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);
if(!array_key_exists('result', $speedtest_linux)) {
    $speedtest_linux["unix_timestamp"] = time();
    $speedtest_linux["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", time());
    $speedtest_linux["speedtest_current"] = $NOT_AVAILABLE_ICON;
    $sql = "
            SELECT  extract(epoch FROM local)::integer AS unix_timestamp,
                    result_url,
                    internal_ip, external_ip,
                    name, host,
                    ping, download, upload
              FROM speedtest
             WHERE wifi
          ORDER BY local DESC
             LIMIT 1
    ";
    $db = db_connect();
    $sth = $db->prepare($sql);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $sth->fetch()) {
        $speedtest_linux["unix_timestamp"] = $row["unix_timestamp"];
        $speedtest_linux["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", $speedtest_windows["unix_timestamp"]);
        $speedtest_linux["speedtest_current"] = $row["result_url"] . ".png";
        $speedtest_linux["interface"]["internalIp"] = $row["internal_ip"];
        $speedtest_linux["interface"]["name"] = "wlp1s0"; // Hardcoded, as it wasn't picked up, bleh.
        $speedtest_linux["server"]["name"] = $row["name"];
        $speedtest_linux["server"]["host"] = $row["host"];
        $speedtest_linux["ping"]["latency"] = $row["ping"];
        $speedtest_linux["download"]["bandwidth"] = ($row["download"] * 1000000.0) / 8.0;
        $speedtest_linux["upload"]["bandwidth"] = ($row["upload"] * 1000000.0) / 8.0;
    }
    $db = null;
} else {
    $speedtest_linux["unix_timestamp"] = strtotime($speedtest_linux["timestamp"]);
    $speedtest_linux["the_time"] = strftime("%Y-%m-%d %H:%M:%S %Z", $speedtest_linux["unix_timestamp"]);
    $speedtest_linux["speedtest_current"] = $speedtest_linux["result"]["url"] . ".png";
}

$speedtest_avg_text = file_get_contents($SPEEDTEST_AVG_FILE);
$speedtest_avg = json_decode($speedtest_avg_text, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="pragma" content="no-cache" />
        <title>Crusty I3 Log Server</title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163395867-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-163395867-1');
        </script>
        <link rel="stylesheet" href="<?php echo $SITE_GLOBAL_CSS;?>">
        <link rel="stylesheet" href="<?php echo $PAGE_SOURCE_CSS;?>">
        <link rel="stylesheet" href="<?php echo $BACKGROUND_CSS;?>">
        <link rel="stylesheet" href="<?php echo $NAVBAR_CSS;?>">
        <style>
            .greeting {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                overflow-x: hidden;
                width: 100%;
                max-width: 100%;
                min-width: 100%;
                background-color: <?php echo $ODD; ?>;
                text-align: left;
                align: left;
            }
            .greeting pre {
                white-space: pre-wrap;
            }
            .hr-75 {
                width: 75%;
                max-width: 75%;
                min-width: 75%;
                align: left;
                text-align: left;
                margin-left: 0;
                border-color: #d0d0d0;
            }
            .hr-100 {
                width: 100%;
                max-width: 100%;
                min-width: 100%;
                align: left;
                text-align: left;
                margin-left: 0;
                border-color: #d0d0d0;
            }

            #content-table {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                overflow-x: hidden;
                min-width: 100%;
                width: 100%;
            }
            #content-table tr:nth-child(even) {
                background-color: <?php echo $EVEN; ?>
            }
            #content-table tr:nth-child(odd) {
                background-color: <?php echo $ODD; ?>
            }
            .content-price-column {
                text-align: right;
                width: 8ch; 
                max-width: 8ch;
                min-width: 8ch;
                padding-right: 2ch;
            }
            .content-message-column {
                text-align: left;
                white-space: normal;
                overflow-x: hidden;
                padding-left: 1ch;
                padding-right: 1ch;
            }
            .content-date-column {
                text-align: left;
                width: 11ch; 
                max-width: 11ch;
                min-width: 11ch;
                padding-left: 2ch;
            }
            .content-status-column {
                text-align: left;
                width: 9ch; 
                max-width: 9ch;
                min-width: 9ch;
                padding-left: 2ch;
            }
            .content-image-column {
                text-align: center;
                vertical-align: top;
                width: 25%; 
                max-width: 25%;
                min-width: 25%;
            }

            #server-case {
                display: block;
                text-align: center;
                align: center;
                vertical-align: center;
            }
            #server-case img {
                border: none;
                max-width: 300px;
                max-height: 300px;
                overflow: hidden;
                object-fit: cover;
            }
            #server-guts {
                display: none;
                text-align: center;
                align: center;
                vertical-align: center;
            }
            #server-guts img {
                border: none;
                max-width: 300px;
                max-height: 300px;
                overflow: hidden;
                object-fit: cover;
            }

            #speedtest-table {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                overflow-x: hidden;
                min-width: 100%;
                width: 100%;
                text-align: center;
                align: center;
                background-color: <?php echo $ODD; ?>;
            }
            .speedtest-left-column {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                text-align: right;
                align: right;
                width: calc(<?php echo $SPEEDTEST_WIDTH; ?> + 20px);
                padding-right: 20px;
            }
            .speedtest-right-column {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                text-align: left;
                align: left;
                width: calc(<?php echo $SPEEDTEST_WIDTH; ?> + 20px);
                padding-left: 20px;
            }
            .speedtest-img {
                border: none;
                max-width: <?php echo $SPEEDTEST_WIDTH; ?>;
                max-height: <?php echo $SPEEDTEST_HEIGHT; ?>;
                overflow: hidden;
                object-fit: cover;
            }
            .speedtest-text-column {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $SMALL_FONT_SIZE; ?>;
                text-align: center;
                align: center;
            }

            .popup-table {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $FONT_SIZE; ?>;
                overflow-x: hidden;
                min-width: 100%;
                width: 100%;
                text-align: center;
                align: center;
                background-color: <?php echo $ODD; ?>;
            }
            .popup-table pre {
                white-space: pre-wrap;
            }
            .popup-text-column {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $SMALL_FONT_SIZE; ?>;
                text-align: left;
                align: left;
                width: 75%;
            }

            .popup-div {
                font-family: Consolas, "Lucida Console", Monaco, Courier, monospace;
                font-size: <?php echo $SMALL_FONT_SIZE; ?>;
                white-space: normal;
                overflow-x: hidden;
                width: 100%;
                max-width: 100%;
                min-width: 100%;
                text-align: center;
                align: center;
                display: none;
                background-color: <?php echo $ODD; ?>;
            }

            #page-load-time {
                font-family: 'Lato', sans-serif;
                font-size: <?php echo $TINY_FONT_SIZE; ?>;
                color: #808080;
                text-align: right;
                align: right;
            }
        </style>

        <script src="<?php echo $JQ;?>"></script>
        <script src="<?php echo $JSCOOKIE;?>"></script>
        <script src="<?php echo $JSRANDOM;?>"></script>
        <script src="<?php echo $JSMD5;?>"></script>
        <script src="<?php echo $MOMENT;?>"></script>
        <script src="<?php echo $MOMENT_TZ;?>"></script>
        <script src="<?php echo $SITE_GLOBAL_JS;?>"></script>
        <script src="<?php echo $BACKGROUND_JS;?>"></script>
        <script src="<?php echo $NAVBAR_JS;?>"></script>

        <script language="javascript">
            var timeSpent;
            var backgroundTimer;
            var fundmeTimer;
            var fundmeAgainTimer;
            var autoFundmeTime = 1000 * 20;

            function toggleLight(divID) {
                element = document.getElementById(divID);
                    //console.log("color: " + element.style.color);
                    // It internally sets the color to "rgb(r, g, b)"...
                    if(element.style.color == 'rgb(128, 128, 128)') {
                        element.style.color = '#00FF00';
                    } else {
                        element.style.color = '#808080';
                    }
            }
            function scrollToAnchor(aId) {
                anchor_tag = $("a[name='" + aId + "']");
                $('html,body').animate({scrollTop: anchor_tag.offset().top - <?php echo "($ICON_BASE * $SCALE)"; ?> }, 'slow');
            }
            function revealHashId() {
                anchor_name = window.location.hash.substring(1);
                //console.log(anchor_name);
                if(anchor_name) {
                    toggleDiv('hacklog');
                    toggleLight('hacklog-light');
                    scrollToAnchor(anchor_name);
                }
            }
            $(document).ready(function() {
<?php if($NOBODY_CARES == false) { ?>
                fundmeTimer = setTimeout(hideFundme, autoFundmeTime);
                fundmeAgainTimer = setTimeout(reshowFundme, autoFundmeTime * 6);
                addClass('fundme-div','fade');
                showDiv('fundme-div');
<?php } ?>
                hideDiv('uptime');
                hideDiv('network');
                hideDiv('cpu');
                hideDiv('memory');
                hideDiv('disk');
                hideDiv('temperature');
                hideDiv('hacklog');
                hideDiv('page-source');
                $('#page-load-time').html(timeSpent);
                showDiv('page-load-time');
                dim(document.getElementById('navbar-button-server'));
                syncBackgroundToggleIcon();
                randomizeBackground();
                updateRefreshTime();
                backgroundTimer = setInterval(randomizeBackground, 1000 * 60 * 5);
                // clearInterval(backgroundTimer);
                setTimeout(revealHashId, 500);
            });
        </script>
    </head>
    <body bgcolor="<?php echo $BGCOLOR; ?>" text="<?php echo $TEXT; ?>" link="<?php echo $UNVISITED; ?>" vlink="<?php echo $VISITED; ?>">
        <div id="background-div">
            <img id="background-img" src="<?php echo $BACKGROUND_URL; ?>" />
        </div>
        <div id="back-navbar">
            <img class="nav-img" title="???!" src="<?php echo $QUESTION_ICON; ?>" />
        </div>
        <div id="navbar-left">
            <img class="nav-img glowing" id="navbar-button-mudlist" title="List of MUDs" src="<?php echo $MUDLIST_ICON; ?>" onclick="window.location.href='<?php echo $MUDLIST_URL; ?>';" />
            <img class="nav-img glowing" id="navbar-button-themudorg" title="I3 Log Page" src="<?php echo $LOG_ICON; ?>" onclick="window.location.href='<?php echo $LOG_URL; ?>';" />
            <img class="nav-img glowing" id="navbar-button-pie" title="Everyone loves PIE!" src="<?php echo $PIE_ICON; ?>" onclick="window.location.href='<?php echo $PIE_URL; ?>';" />
            <img class="nav-img glowing spinning" id="navbar-button-forum" title="Dead Forums" src="<?php echo $FORUM_ICON; ?>" onclick="window.location.href='<?php echo $FORUM_URL; ?>';" />
            <img class="nav-small-img glowing" id="navbar-button-background" title="Make boring." src="<?php echo $BG_ON_ICON; ?>" onclick="toggleBackground();" />
            <img class="nav-small-img glowing" id="navbar-button-question" title="???!" src="<?php echo $QUESTION_ICON; ?>" onclick="window.location.href='<?php echo $QUESTION_URL; ?>';" />
        </div>
        <div id="navbar-center">
            <table id="wileymud-table">
                <tr>
                    <td rowspan="2" align="right" width="<?php echo $WILEY_BANNER_WIDTH; ?>">
                        <img class="nav-banner-img glowing" id="navbar-button-wileymud" width="<?php echo $WILEY_BANNER_WIDTH; ?>" title="<?php echo "$WILEY_IP $WILEY_PORT"; ?>" src="<?php echo $WILEY_BANNER_ICON; ?>" />
                    </td>
                    <td class="wileymud-gap">&nbsp;</td>
                    <td class="wileymud-version" align="right">
                        Version:
                    </td>
                    <td class="wileymud-gap">&nbsp;</td>
                    <td class="wileymud-version" align="left">
                        <?php echo $WILEY_BUILD_NUMBER; ?>
                    </td>
                </tr>
                <tr>
                    <td class="wileymud-gap">&nbsp;</td>
                    <td class="wileymud-build-date" align="right">
                        Build Date:
                    </td>
                    <td class="wileymud-gap">&nbsp;</td>
                    <td class="wileymud-build-date" align="left">
                        <?php echo $WILEY_BUILD_DATE; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="navbar-right">
            <span id="refresh-time">--:-- ---</span>
            <img class="nav-img" id="navbar-button-server" title="Crusty Server Statistics" src="<?php echo $SERVER_ICON; ?>" />
            <img class="nav-img glowing" id="navbar-button-github" title="All of this in Github" src="<?php echo $GITHUB_ICON; ?>" onclick="window.location.href='<?php echo $GITHUB_URL; ?>';" />
            <img class="nav-img glowing" id="navbar-button-discord" title="The I3 Discord" src="<?php echo $DISCORD_ICON; ?>" onclick="window.location.href='<?php echo $DISCORD_URL; ?>';" />
        </div>
        <div id="fake-navbar">
            <img class="nav-img" title="???!" src="<?php echo $QUESTION_ICON; ?>" />
        </div>
        <div class="greeting">
            <h1>Old Crusty MUD Server</h1>
            <hr class="hr-75" />
        </div>
        <table id="content-table">
            <tr>
                <td class="content-price-column">54.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16813157335">ASRock B75M-DGS LGA 1155 Intel B75 Micro ATX Intel Motherboard</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
                <td class="content-image-column" rowspan="0">
                    <div id="server-case">
                        <img onmousedown="hideDiv('server-case'); showDiv('server-guts');" src="<?php echo $SERVER_CASE; ?>" />
                    </div>
                    <div id="server-guts">
                        <img onmousedown="hideDiv('server-guts'); showDiv('server-case');" src="<?php echo $SERVER_GUTS; ?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td class="content-price-column">49.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16811147153">Rosewill CHALLENGER Black Gaming ATX Mid Tower Case</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">36.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16817139026">Corsair CX430 ATX Active PFC Power Supply</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">49.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16820231489">G.Skill Ripjaw X Series 16GB (2 x 8GB) DDR3 SDRAM (PC3 12800)</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">15.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16827106289">Lite-On SATA DVD Burner</a> (A burner was cheaper than a non-burner!)</td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">64.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16819116406">Intel Pentium G630 Sandy Bridge 2.7GHz Dual Core CPU (LGA 1155)</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">74.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16822236070">WD Cavier Green 1TB SATA hard drive</a></td>
                <td class="content-date-column">2012-11-21</td>
                <td class="content-status-column">RECYCLED</td>
            </tr>
            <tr>
                <td class="content-price-column">119.99</td>
                <td class="content-message-column"><a target="__pricelist" href="http://www.newegg.com/Product/Product.aspx?Item=N82E16822136749">WD My Book 3TB Desktop USB 3.0 External Hard Drive</a> (now internal)</td>
                <td class="content-date-column">2015-06-11</td>
                <td class="content-status-column">RECYCLED</td>
            </tr>
            <tr>
                <td class="content-price-column">147.99</td>
                <td class="content-message-column"><a target="__pricelist" href="https://www.amazon.com/gp/product/B00IRRDHUI/">Crucial M550 256GB SATA 2.5" 7mm (with 9.5mm adapter) Internal Solid State Drive</a></td>
                <td class="content-date-column">2018-01-17</td>
                <td class="content-status-column">RECYCLED</td>
            </tr>
            <tr>
                <td class="content-price-column"><s>34.99</s></td>
                <td class="content-message-column"><s><a target="__pricelist" href="https://www.amazon.com/gp/product/B016K0896K/">TP-Link AC1300 PCIe WiFi PCIe Card(Archer T6E)- 2.4G/5G Dual Band Wireless PCI Express Adapter</a></s></td>
                <td class="content-date-column"><s>2020-12-24</s></td>
                <td class="content-status-column">REMOVED</td>
            </tr>
            <tr>
                <td class="content-price-column">----.--</td>
                <td class="content-message-column">&nbsp;</td>
                <td class="content-date-column">----------</td>
                <td class="content-status-column">&nbsp;</td>
            </tr>
            <tr>
                <td class="content-price-column">269.71</td>
                <td class="content-message-column">Total purchase price</td>
                <td class="content-date-column">2020-12-24</td>
                <td class="content-status-column">TOTAL</td>
            </tr>
        </table>

        <div class="greeting">
            <hr class="hr-75" />
        </div>
        <table id="speedtest-table">
            <tr>
                <!-- <td class="speedtest-left-column"> <img class="speedtest-img" src="<?php echo $speedtest_windows['speedtest_current']; ?>" /> </td> -->
                <!-- <td class="speedtest-left-column"> <img class="speedtest-img" src="<?php echo $ONE_PIXEL_ICON; ?>" /> </td> -->
                <td class="speedtest-left-column"> <img class="speedtest-img" src="<?php echo $speedtest_linux['speedtest_current']; ?>" /> </td>
                <td class="speedtest-text-column" rowspan="0">
                <pre>
                <?php
                    printf("%s      \n", ">>> This Week's Performance Average <<<");
                    printf("%27s %20s %20s %20s\n", "Interface", "Average Ping", "Average Download", "Average Upload");
                    printf("%27s %20s %20s %20s\n", "---------------------------", "--------------------", "--------------------", "--------------------");
                    ksort($speedtest_avg);
                    foreach ($speedtest_avg as $k => $v) {
                        $wire   = sprintf("%s (%s)", substr($k, -19), $v["wire"]);
                        $ping   = sprintf("%.3f ms", $v["ping"]);
                        $down   = sprintf("%.3f Mbps", $v["download"]);
                        $up     = sprintf("%.3f Mbps", $v["upload"]);
                        printf("%26s %20s %20s %20s\n", $wire, $ping, $down, $up);
                    }
                ?>
                </pre>
                </td>
                <!-- <td class="speedtest-right-column"> <img class="speedtest-img" src="<?php echo $speedtest_linux['speedtest_current']; ?>" /> </td> -->
                <td class="speedtest-right-column"> <img class="speedtest-img" src="<?php echo $ONE_PIXEL_ICON; ?>" /> </td>
            </tr>
            <tr>
                <!-- <td class="speedtest-left-column">Bellevue&nbsp;(angband)</td> -->
                <!-- <td class="speedtest-left-column">&nbsp;</td> -->
                <!-- <td class="speedtest-right-column">Bellevue&nbsp;(lenin)</td> -->
                <td class="speedtest-left-column">Bellevue&nbsp;(lenin)</td>
                <td class="speedtest-right-column">&nbsp;</td>
            </tr>
        </table>

        <div class="greeting">
            <hr class="hr-100" />
            <span style="font-size: <?php echo $BIG_FONT_SIZE; ?>;">
                <span id="uptime-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('uptime'); toggleLight('uptime-light');">Uptime</a>
                <span id="network-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('network'); toggleLight('network-light');">Network</a>
                <span id="cpu-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('cpu'); toggleLight('cpu-light');">CPU</a>
                <span id="memory-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('memory'); toggleLight('memory-light');">Memory</a>
                <span id="disk-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('disk'); toggleLight('disk-light');">Disk</a>
                <span id="temperature-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('temperature'); toggleLight('temperature-light');">Temperature</a>
                <span id="hacklog-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('hacklog'); toggleLight('hacklog-light');">HACKLOG</a>
                <span id="page-source-light" style="color: #808080;">&diams;</span>
                <a href="javascript:;" onmousedown="toggleDiv('page-source'); toggleLight('page-source-light');">Source</a>
            </span>
            <div id="page-load-time" align="right">Page Loaded.</div>
        </div>

        <div id="uptime" >
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                        <?php pcmd("/bin/cat /proc/version"); ?>
                        <pre><?php pcmd("/usr/bin/uptime"); ?></pre>
                        <pre><?php pcmd("/usr/bin/clang --version | /usr/bin/head -1"); ?></pre>
                        <pre><?php pcmd("/usr/bin/gcc --version | /usr/bin/head -1"); ?></pre>
                        <pre><?php pcmd("/usr/bin/psql --version | /usr/bin/head -1"); ?></pre>
                        <pre><?php pcmd("/usr/bin/systemctl --no-pager status --lines 0 wileymud_driver"); ?></pre>
                        <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="network">
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                            <pre>Blacklist entries: <?php pcmd("/bin/cat /etc/iptables/ipset.blacklist | /usr/bin/grep -v 'create blacklist' | /usr/bin/wc -l"); ?></pre>
<!--
                            <pre><?php pcmd("/usr/bin/nmcli -f 'DEVICE,CHAN,BARS,SIGNAL,RATE,SSID' dev wifi | /usr/bin/egrep '(\s+SSID|\s+Dread_.748)'"); ?></pre>
                            <pre>Wifi Connection in use: <?php pcmd("/sbin/iwconfig wlp1s0 | grep ESSID"); ?></pre>
-->
                            <pre>External IPv4 address: <?php pcmd("/home/wiley/bin/mudinfo -I wileymud"); ?></pre>
<!--
                            <pre><?php
                                    printf("%s %s\n",         "Windows Speedtest performed on", $speedtest_windows["the_time"]);
                                    printf("%s %s:%s\n",      "                  interface   ", $speedtest_windows["interface"]["internalIp"], $speedtest_windows["interface"]["name"]);
                                    printf("%s %s (%s)\n",    "                  target node ", $speedtest_windows["server"]["name"], $speedtest_windows["server"]["host"]);
                                    printf("%s %-.3f ms\n",   "                  ping        ", $speedtest_windows["ping"]["latency"]);
                                    printf("%s %-.2f Mbps\n", "                  download    ", ($speedtest_windows["download"]["bandwidth"] * 8.0 / 1000000.0));
                                    printf("%s %-.2f Mbps\n", "                  upload      ", ($speedtest_windows["upload"]["bandwidth"] * 8.0 / 1000000.0));
                                 ?>
                            </pre>
-->
                            <pre><?php
                                    printf("%s %s\n",         "Linux Speedtest   performed on", $speedtest_linux["the_time"]);
                                    printf("%s %s:%s\n",      "                  interface   ", $speedtest_linux["interface"]["internalIp"], $speedtest_linux["interface"]["name"]);
                                    printf("%s %s (%s)\n",    "                  target node ", $speedtest_linux["server"]["name"], $speedtest_linux["server"]["host"]);
                                    printf("%s %-.3f ms\n",   "                  ping        ", $speedtest_linux["ping"]["latency"]);
                                    printf("%s %-.2f Mbps\n", "                  download    ", ($speedtest_linux["download"]["bandwidth"] * 8.0 / 1000000.0));
                                    printf("%s %-.2f Mbps\n", "                  upload      ", ($speedtest_linux["upload"]["bandwidth"] * 8.0 / 1000000.0));
                                 ?>
                            </pre>
                            <pre><?php echo htmlentities(file_get_contents($KELLY_MTR)); ?></pre>
                            <pre><?php echo htmlentities(file_get_contents($DALET_MTR)); ?></pre>
                            <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="cpu" >
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                        <pre><?php pcmd("/bin/cat /proc/cpuinfo"); ?></pre>
                        <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="memory" >
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                        <pre><?php pcmd("/usr/bin/free --mega -h"); ?></pre>
                        <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="disk" >
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                        <pre><?php pcmd("/bin/df -h | /bin/grep -v 'udev' | /bin/grep -v 'tmpfs' | /bin/grep -v 'by-uuid'"); ?></pre>
                        <pre><?php echo htmlentities(file_get_contents($DISK_SMART)); ?></pre>
                        <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="temperature" >
            <table class="popup-table">
                <tr>
                    <td>&nbsp;</td>
                    <td class="popup-text-column">
                        <pre><?php pcmd("/usr/bin/sensors"); ?></pre>
                        <hr class="hr-100" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

<?php
        $hacklog = htmlentities(file_get_contents("/home/www/log/data/HACKLOG.rev"));
        $hacklog = preg_replace(
            '/^([0-9][0-9][0-9][0-9]\-[0-9][0-9]\-[0-9][0-9])$/m',
            '<a name="hacklog_$1">$1</a>',
            $hacklog);
?>
        <div id="hacklog" class="greeting">
            <pre><?php echo $hacklog; ?></pre>
            <hr class="hr-100" />
        </div>

        <div id="page-source">
            <?php echo numbered_source(__FILE__); ?>
        </div>
        <?php
            $time_end = microtime(true);
            $time_spent = $time_end - $time_start;
        ?>
        <script language="javascript">
            timeSpent = "<?php printf("Page Loaded in %7.3f seconds.",  $time_spent); ?>";
        </script>
<?php if($NOBODY_CARES == false) { ?>
        <div class="<?php echo $FUNDME_CLASS; ?>" id="fundme-div"
            data-url="<?php echo $FUNDME_DATA_URL; ?>">
        </div>
        <script defer src="<?php echo $FUNDME_SRC_URL; ?>"></script>
<?php } ?>
    </body>
</html>

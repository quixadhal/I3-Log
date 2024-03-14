<?php
require_once 'site_global.php';
header("Content-Type: application/json; charset=UTF-8");
?>
// 0 -> 23
var hour_map = [
    '#555555', // 0000
    '#555555',
    '#555555',
    '#555555',
    '#bb0000', // 0400
    '#bb0000',
    '#bbbb00', // 0600
    '#bbbb00',
    '#ffff55', // 0800
    '#ffff55',
    '#00bb00', // 1000
    '#00bb00',
    '#55ff55', // 1200
    '#55ff55',
    '#bbbbbb', // 1400
    '#bbbbbb',
    '#55ffff', // 1600
    '#55ffff',
    '#00bbbb', // 1800
    '#00bbbb',
    '#5555ff', // 2000
    '#5555ff',
    '#0000bb', // 2200
    '#0000bb'
];
function toggleDiv(divID) {
    element = document.getElementById(divID);
    if(element !== undefined && element !== null) {
        if(element.style.display == 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
}
function showDiv(divID) {
    element = document.getElementById(divID);
    if(element !== undefined && element !== null) {
        element.style.display = 'block';
    }
}
function hideDiv(divID) {
    element = document.getElementById(divID);
    if(element !== undefined && element !== null) {
        element.style.display = 'none';
    }
}
function scroll_to(id) {
    document.getElementById(id).scrollIntoView({behavior: 'smooth', block: "center"});
}
function addClass(elementID, className) {
    element = document.getElementById(elementID);
    if(element !== undefined && element !== null) {
        element.classList.add(className);
    }
}
function removeClass(elementID, className) {
    element = document.getElementById(elementID);
    if(element !== undefined && element !== null) {
        element.classList.remove(className);
    }
}
function dim(element) {
    if(element !== null) {
        element.style.opacity = "0.5";
        element.classList.remove('glowing');
        //element.className = "not-glowing";
    }
}
function brighten(element) {
    if(element !== null) {
        element.style.opacity = "1.0";
        element.classList.add('glowing');
        //element.className = "glowing";
    }
}
function at_bottom() {
    var body = document.body;
    var html = document.documentElement;
    var doc_height = Math.max( body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight );
    var atBottom = false;
    if( window.innerHeight >= doc_height ) {
        // The page cannot scroll... so yes, but no.
    } else if( (window.innerHeight + window.pageYOffset) >=
        (document.body.offsetHeight) ) {
        // We are at the bottom of the page.
        atBottom = true;
    }
    return atBottom;
}
function secsToHMS(s) {
    var d = Math.floor(s / 86400);
    s -= d * 86400;
    var h = Math.floor(s / 3600);
    s -= h * 3600;
    var m = Math.floor(s / 60);
    s -= m * 60;
    var output = '';
    if(d > 0) {
        output = output + d + ' d';
    }
    if(h > 0) {
        var ph = '0' + h;
        output = output + ph.substr(-2) + ':';
    }
    var pm = '0' + m;
    output = output + pm.substr(-2) + ':';
    var ps = '0' + s;
    output = output + ps.substr(-2);
    return output;
}
function server_date() {
    // This is only true when the page first loads
    return "<?php echo date("Y-m-d"); ?>";
}
function server_time_midnight() {
    // This is only true when the page first loads
    // return <?php date_default_timezone_set("America/Los_Angeles"); $dt = new DateTime(date("Y-m-d")); echo $dt->format("U"); ?>;
    return <?php $dt = new DateTime(date("Y-m-d")); echo $dt->format("U"); ?>;
}
function query_parameters() {
    const queryString = window.location.search.substr(1);
    const queryParams = queryString.split('&').reduce(
        (queryResults, thisParam) => {
            const [k,v] = thisParam.split('=');
            queryResults[k] = decodeURIComponent(v);
            return queryResults;
            }, {}
        );
    return queryParams;
}
function https() {
    return "<?php echo https(); ?>";
}
function hideFundme() {
    clearTimeout(fundmeTimer);
    hideDiv('fundme-div');
}
function reshowFundme() {
    clearTimeout(fundmeAgainTimer);
    fundmeTimer = setTimeout(hideFundme, autoFundmeTime);
    fundmeAgainTimer = setTimeout(reshowFundme, autoFundmeTime * 6);
    showDiv('fundme-div');
    var fd = document.getElementById('fundme-div');
    fd.style.animation = 'none';
    fd.offsetHeight;
    fd.style.animation = null;
}


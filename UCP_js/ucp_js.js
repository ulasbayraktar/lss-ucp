include_once('UCP_js/jquery.ui.js');
include_once('UCP_js/jquery.picker.js');
include_once('UCP_js/jquery.tablesort.js');
include_once('UCP_js/jquery.tip.js');
include_once('UCP_js/ucp_jquery.js');
include_once('UCP_js/fader.js');

function Replace(pattern)
{
    var szReplacement = pattern;
    szReplacement = szReplacement.replace(/\n/g, "<br>");
    szReplacement = szReplacement.replace(/\[tooltip=(.*?)\](.*?)\[\/tooltip\]/gi,"<a class=\"basic_tooltip\" title=\"$1\">$2</a>");
    szReplacement = szReplacement.replace(/\[b\](.*?)\[\/b\]/gi, "<b>$1</b>");
    szReplacement = szReplacement.replace(/\[i\](.*?)\[\/i\]/gi, "<i>$1</i>");
    szReplacement = szReplacement.replace(/\[u\](.*?)\[\/u\]/gi, "<u>$1</u>");
    szReplacement = szReplacement.replace(/\[center\](.*?)\[\/center\]/gi, "<center>$1</center>");
    szReplacement = szReplacement.replace(/\[url\](.*?)\[\/url\]/gi, "<a href=\"$1\">$1</a>");
    szReplacement = szReplacement.replace(/\[url=(.*?)\](.*?)\[\/url\]/gi, "<a href=\"$1\">$2</a>");
    szReplacement = szReplacement.replace(/\[img](.*?)\[\/img\]/gi,"<img style=\"max-width:700px;\" src=\"$1\" alt=\"Image\" />");
    szReplacement = szReplacement.replace(/\[color=(.*?)\](.*?)\[\/color\]/gi, "<font color=\"$1\">$2</font>");
    szReplacement = szReplacement.replace(/\[size=(.*?)\](.*?)\[\/size\]/gi, "<font size=\"$1\">$2</font>");
    szReplacement = szReplacement.replace(/\[font=(.*?)\](.*?)\[\/font\]/gi, "<font face=\"$1\">$2</font>");
    szReplacement = szReplacement.replace(/\[align=(.*?)\](.*?)\[\/align\]/gi, "<p align=\"$1\">$2</p>");
    szReplacement = szReplacement.replace(/\[list](.*?)\[\/list\]/gi, "<ul>$1</ul>");
    szReplacement = szReplacement.replace(/\[li](.*?)\[\/li\]/gi, "<li>$1</li>");
    szReplacement = szReplacement.replace(/\[aligntable=(.*?),(.*?),(.*?),(.*?),(.*?),(.*?)\](.*?)\[\/aligntable\]/gi, "<div style=\"float:$1; margin: 0px $4px 0px $3px;\"><table width=\"$2\" border=\"$5\" bordercolor=\"$6\"><tr><td>$7</td></tr></table></div>");
    szReplacement = szReplacement.replace(/\[quote\](.*?)\[\/quote\]/gi, "<blockquote>$1</blockquote>");
    szReplacement = szReplacement.replace(/\[quote=(.*?)\](.*?)\[\/quote\]/i, "<blockquote><cite>$1 wrote:</cite>$2</blockquote>");
    return szReplacement;
}

function bookmark_us(url, title) 
{
    if (window.sidebar) {
        window.sidebar.addPanel(title, url, "");
    } else if(window.opera && window.print) {
        var elem = document.createElement('a');
        elem.setAttribute('href',url);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    } else if(document.all) {
        window.external.AddFavorite(url, title);
    }
}

function showLogin() {
    $(window).load(function () {
        $("#dialog").dialog("open");
    });
}

function Fade(divid,duration)
{
    $(document).ready(function() {
        $(divid).fadeIn(duration);
    });
}

function SlideRight(divid,duration)
{
    $(document).ready(function() {
        $(divid).show("slide", {
            direction: "left"
        }, 4000);
    });
}

function FadeOut(divid,duration)
{
    $(document).ready(function() {
        $(divid).fadeOut(duration);
    });
}

function Slide(divid,duration)
{
    $(document).ready(function() {
        $(divid).slideDown(duration);
    });
}

function addTags(Tag,fTag,Message)
{
    var obj = document.form.message;
    obj.focus();
    if (document.selection && document.selection.createRange) {
        sel = document.selection.createRange();
        if (sel.parentElement() == obj)  sel.text = Tag + sel.text + fTag;
    } else if (typeof(obj) != "undefined") {
        var longueur = parseInt(obj.value.length);
        var selStart = obj.selectionStart;
        var selEnd = obj.selectionEnd;
        obj.value = obj.value.substring(0,selStart) + Tag + obj.value.substring(selStart,selEnd) + fTag + obj.value.substring(selEnd,longueur);
    }
    else obj.value += Tag + fTag;
    obj.focus();
}

function include_once(src) 
{
    var scripts = document.getElementsByTagName('script');
    if(scripts) {
        for(var k=0; k<scripts.length; k++) {
            // script schon geladen, abbrechen
            if(scripts[k].src == src) {
                return;
            }
        }
    }
    var script = document.createElement('script');
    script.src = src;
    script.type = 'text/javascript';
    (document.getElementsByTagName('HEAD')[0] || document.body).appendChild(script);
}

var faders = {};
function map_over(id, x, y)
{
    if (!faders[id])
    {
        faders[id] = new fader(document.getElementById("map_info_"+id));
        faders[id].opacityMax = 90;
        faders[id].hide();
        if (parseInt(faders[id].ref.style.left) > 550)
        {
            faders[id].ref.style.left = "550px";
        }
    }
    if (faders[id].opacity <= 0) faders[id].timeout = setTimeout(function(){
        faders[id].fadeIn()
        },150);
    else faders[id].fadeIn();
	
    var map = document.getElementById("map_bgline");
}

function map_out(id)
{
    var map = document.getElementById("map_bgline");
    map.style.backgroundImage = "";
    clearTimeout(faders[id].timeout);
    faders[id].fadeOut();
}

/*function nocopypaste(e)
{
    var code = (document.all) ? event.keyCode:e.which;
    var msg = "Sorry, this functionality is disabled.";
    if (parseInt(code)==17)
    {
        alert(msg);
        window.event.returnValue = false;
        e.blur();
    }
}*/

function insertTab(o, e)
{
    var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
    if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey) {
        var oS = o.scrollTop;
        if (o.setSelectionRange) {
            var sS = o.selectionStart;
            var sE = o.selectionEnd;
            o.value = o.value.substring(0, sS) + "\t" + o.value.substr(sE);
            o.setSelectionRange(sS + 1, sS + 1);
            o.focus();
        } else if (o.createTextRange) {
            document.selection.createRange().text = "\t";
            e.returnValue = false;
        }
        o.scrollTop = oS;
        if (e.preventDefault) {
            e.preventDefault();
        }
        return false;
    }
    return true;
}

function numbersonly(myfield, e, dec)
{
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);

    // control keys
    if ((key==null) || (key==0) || (key==8) || 
        (key==9) || (key==13) || (key==27) )
        return true;

    // numbers
    else if ((("0123456789*").indexOf(keychar) > -1))
        return true;

    // decimal point jump
    else if (dec && (keychar == "."))
    {
        myfield.form.elements[dec].focus();
        return true;
    }
    else
        return false;
}

function iponly(myfield, e, dec)
{
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);

    // control keys
    if ((key==null) || (key==0) || (key==8) || 
        (key==9) || (key==13) || (key==27) )
        return true;

    // numbers
    else if ((("0123456789.*").indexOf(keychar) > -1))
        return true;

    // decimal point jump
    else if (dec && (keychar == "."))
    {
        myfield.form.elements[dec].focus();
        return true;
    }
    else
        return false;
}

function limitText(limitField, limitCount, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    } else {
        limitCount.value = limitNum - limitField.value.length;
    }
}

function fetchAjaxPageContent(url, areaName, forminput) {
    var areaId=document.getElementById(areaName);
    
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: $(forminput).serialize(),
        beforeSend: function() {
            //$('#'+id+' .contentarea').html('<b>Loading content...</b>');
            areaId.innerHTML='Loading';
        },
        success: function(data, textStatus, xhr) {

            //if (url == '/function-demos/functions/ajax/data/content3.html')
            //{
                /*setTimeout( function() {
                    $('#'+id+' .contentarea').html(data);
                }, 2000);*/
            /*}
            else
            {
                $('#'+id+' .contentarea').html(data);
            }*/
            areaId.innerHTML=data;
        },
        error: function(xhr, textStatus, errorThrown) {
            areaId.innerHTML="Error";
        }
    });
}
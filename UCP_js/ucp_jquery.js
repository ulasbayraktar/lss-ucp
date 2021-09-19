$(function() {
    $("#admin_tab").tabs();
    $("#dialog").dialog({
        bgiframe: true,
        modal: true,
        autoOpen: false,
        resizable: false,
        draggable: false,
        width: 400,
        show: 'slide',
        height: 325
    });
    $("#lostPass").dialog({
        bgiframe: true,
        modal: true,
        autoOpen: false,
        resizable: false,
        draggable: false,
        show: 'slide',
        hide: 'slide',
        width: 400,
        height: 300
    });
    $("#lostUser").dialog({
        bgiframe: true,
        modal: true,
        autoOpen: false,
        resizable: false,
        draggable: false,
        show: 'slide',
        hide: 'slide',
        width: 400,
        height: 300
    });
    $("#ucp-tutorial").dialog({
        bgiframe: true,
        modal: true,
        autoOpen: false,
        resizable: false,
        draggable: true,
        width: 850,
        show: 'slide',
        hide: 'slide',
        height: 600
    });
    $("#ucp-signature").dialog({
        title: 'Signature codes',
        bgiframe: true,
        modal: false,
        autoOpen: false,
        resizable: true,
        draggable: true,
        hide: 'slide',
        position: 'top',
        show: 'slide',
        width: 550,
        height: 400
    });	
    $("#popupLogin").bind("click", function(){
        $("#dialog").dialog("open");
    });
    $(".popupLogin").bind("click", function(){ 
        $("#dialog").dialog("open"); 
        return 0;
    });
    $("#popupTUT").bind("click", function(){ 
        $("#ucp-tutorial").dialog("open"); 
        return 0;
    });
    $("#popupPassword").bind("click", function(){
        $("#dialog").dialog("close"); 
        $("#lostPass").dialog("open"); 
        return 0;
    });
    $("#popupUserlost").bind("click", function(){
        $("#dialog").dialog("close"); 
        $("#lostUser").dialog("open"); 
        return 0;
    });
    $(".popupSignature").bind("click", function(){
        $("#ucp-signature").dialog("open"); 
        return 0;
    });
    $("#showedit").bind("click", function(){ 
        $("#publicedit").dialog("open"); 
        return 0;
    });
    $("#accordion").accordion({
        clearStyle: true
    });
    $("#progressbar").progressbar({
        value: 0
    });
    $("#app_table").tablesorter();
    $(".table_sort").tablesorter();
    $(".black_button").button();
    $(".basic_tooltip").tipTip({
        delay: 0, 
        fadeIn: 0, 
        fadeOut: 0, 
        defaultPosition: "top"
    });
    $(".info_tooltip").tipTip({
        maxWidth: "700px", 
        edgeOffset: 10, 
        defaultPosition: "right"
    });
    $(".tab_style").tabs();
    $("#button").button();
    $("#datepicker").datepicker();
    $('#colorSelector').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector div').css('backgroundColor', '#' + hex);
        }
    });
    $("#button_2").button();
    $("#button_3").button();
    $(".hover_out").hover(function() {
        $(this).stop().fadeTo(800,1);
    },function() {
        $(this).stop().fadeTo(800,0.4);
    }
    );
    $("ul.thumb li").hover(function() {
        $(this).css({
            'z-index' : '10'
        });
        $(this).find('img').addClass("hover").stop()
        .animate({
            marginTop: '-100px',
            marginLeft: '-100px',
            top: '50%',
            left: '50%',
            width: '240px', 
            height: '60px',
            padding: '20px'
        }, 200);

    } , function() {
        $(this).css({
            'z-index' : '0'
        }); 
        $(this).find('img').removeClass("hover").stop() 
        .animate({
            marginTop: '0', 
            marginLeft: '0',
            top: '0',
            left: '0',
            width: '200px', 
            height: '50px',
            padding: '5px'
        }, 400);
    });
    $(".signin").click(function(e) {          
        e.preventDefault();
        $("fieldset#signin_menu").toggle();
        $(".signin").toggleClass("menu-open");
    });	
    $("fieldset#signin_menu").mouseup(function() {
        return false;
    });
    $(document).mouseup(function(e) {
        if($(e.target).parent("a.signin").length==0) {
            $(".signin").removeClass("menu-open");
            $("fieldset#signin_menu").hide();
        }
    });
});
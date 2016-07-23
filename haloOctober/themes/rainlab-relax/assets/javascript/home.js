

$(document).ready(function () {
    $("#main_nav dl dt").mouseover(function () {
        $("#main_nav dl dd").hide();
        $(this).nextAll("dd").show();
    });
    $("#main_nav dl").mouseout(function () {
        $("#main_nav dl dd").hide();
    });
    $("#main_nav dl dd").mouseover(function () {
        $(this).parent().children("dd").show();
    });
//    $('#featured').orbit({ captions:true, directionalNav:false});

    if ($("#scroll_list li").length > 8) {
        var l = $("#scroll_list li").length - 8;
        var t1 = setInterval("scrollist()", 40);
    }
//    showHint(statusQuery.appCode, '请输入申请登记号');
//    showHint(statusQuery.captcha,'请输入验证码');
    //for auto-run photo slides
  

    // if(!!$.cookie('index_reminder')){
    //     var d = new Date();
    //     var now = d.getTime();
    //     var r = $.cookie('index_reminder');
    //     var expire = 1000*60*60*8;
    //     (now - parseInt(r)) > expire ? remind() : false;
    // }else{
    //     remind();
    // }

    // function remind(){
    //     var d = new Date();
    //     var now = d.getTime();
    //     // Sun Oct 12 2014 00:00:00 GMT+0800 (HKT)
    //     if(now > 1413043200000) return false;
    //     reminder();
    //     $.cookie('index_reminder', now, { expires: 1, path: '/' });
    // }

    // function reminder(){
    //     var rmd = $('<div class="reminder" id="reminder">');
    //     var close = $('<span class="reminder-close">X</span>');
    //     $(close).on('click', function(){$(rmd).remove();});
    //     $(rmd).append('<div class="reminder-bg"></div>', $('<div class="reminder-box">').append(close));
    //     $('body').append(rmd);
    // }
});

function scrollist() {
    var l = $("#scroll_list li").length - 8;
    d = $("#scroll_list li").first().css("margin-top").replace("px", "") - 0 - 1;
    if (d * -1 >= l * 22) {
        fhtml = $("#scroll_list li").first().html();
        $("#scroll_list li").first().remove();
        $("<li>" + fhtml + "</li>").appendTo("#scroll_list");
        d = d + 22;
    }
    $("#scroll_list li").first().css({"margin-top":d});

}

function validForm()
{
    if (document.searchForm.kw.value == "")
    {
        alert("请输入关键词后再点搜索");
        document.searchForm.kw.focus();
        return false;
    }
    else
    {
        document.searchForm.submit();
        return true;
    }
}

function showHint( element,hint)
{
    if (element.value == "")
    {
        element.value = hint;
    }
}
function hideHint( element,hint)
{
    if (element.value == hint)
    {
        element.value = "";
    }
}


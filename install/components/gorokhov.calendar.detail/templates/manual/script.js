$(document).ready(function(){
    $( function() {
        $(".js-click-item").on("click",function(){
            timeSend = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: JSParamsComponentCalendar.ajaxPath,
                data: {
                    "IS_AJAX" : "Y",
                    "time" : timeSend,
                },
                success : function(data){
                    alert(data);
                }
            });
        });
    } );
});
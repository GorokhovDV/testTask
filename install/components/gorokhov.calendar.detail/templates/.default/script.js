$(document).ready(function(){
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: "dd.mm.yy",
            onSelect: function(dateText, inst) {
                var date = $(this).val();
                $.ajax({
                    type: "POST",
                    url: JSParamsComponentCalendar.ajaxPath,
                    data: {
                        "IS_AJAX" : "Y",
                        "time" : date,
                    },
                    success : function(data){
                        alert(data);
                    }
                });
            }
        });
    } );
});
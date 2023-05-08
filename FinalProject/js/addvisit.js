
$( document).ready(function() {
    $("ol").on("click", ".bookmarkList", function(){
        var bookmarkID = $(this).attr("id");
        $.ajax({
            url: 'add-visit.php',
            type: 'POST',
            data: {bookmarkID: bookmarkID},
            success: function(response) {
                $("body").html(response);
            },
            error: function(error){
                alert(error);
            }
        });
    });
});


$(document).ready(function() {
    $("#bookmarks").show();
    $("#listBookmarks").addClass("active");

    $(".tablinks").on("click", function(){
        var tabID = $(this).data("tab");

        $(".tabcontent").hide();
        $(tabID).show();


        $(".tablinks").removeClass("active");
        $(this).addClass("active");
        
    })

    $(".btnAdd").on("click", function(){

        $(".btnDelete").removeClass("active");
        $(this).addClass("active");
    });

    $(".btnDelete").on("click", function() {
        
        $(".btnAdd").removeClass("active");
        $(this).addClass("active");
    });

});

$(document).ready(function () {

    if($(".errors").length > 0){
        setTimeout(function() {
            $(".errors").fadeOut();
        }, 1000);
    }
});
  
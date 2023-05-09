
$( document).ready(function() {
    $("ol").on("click", ".bookmarkList", function(){
        var bookmarkID = $(this).attr("id");
        var cleanBookmarkID = "";
        if(bookmarkID.includes('m_')){
            var cleanBookmarkID = bookmarkID.replace('m_', '');
        } else {
            var cleanBookmarkID = bookmarkID.replace('p_', '');
        }

        $.ajax({
            url: 'add-visit.php',
            type: 'POST',
            data: {bookmarkID: cleanBookmarkID},
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
        var funcID = $(this).data("tab");
        console.log(funcID);
        $(".funccontent").hide();
        $(funcID).show()

        $(".btnDelete").removeClass("active");
        $(this).addClass("active");
    });

    $(".btnDelete").on("click", function() {
        var funcID = $(this).data("tab");

        $(".funccontent").hide();
        $(funcID).show()

        $(".btnAdd").removeClass("active");
        $(this).addClass("active");
    });

});

$(document).ready(function () {

    if($(".errors").length > 0){
        setTimeout(function() {
            $(".errors").fadeOut();
        }, 3000);
    }
});
  
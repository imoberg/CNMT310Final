
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
    $(".tablinks[data-tab='bookmarks']").addClass("active");

    $(".tablinks").on("click", function(){
        var tabID = $(this).data("tab");

        $(".tabcontent").hide();
        $(tabID).show();


        $(".tablinks").removeClass("active");
        $(this).addClass("active");
        
    })

});
  
// $( document).ready(function() {
//     $(".tablinks").on("click", function() {
//         alert("clicked");
//         var type = $(this).attr("id");
//         $(".tabcontent").hide();
//         $("#" + type ).show();

//         $(".tablinks").removeClass("active");
//         $(this).addClass("active");
        
        
//     })
// });
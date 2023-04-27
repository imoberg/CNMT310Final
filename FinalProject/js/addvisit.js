
$( document).ready(function() {
    $(".scrollable-ol a").on("click", function(){
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

//.click or .on


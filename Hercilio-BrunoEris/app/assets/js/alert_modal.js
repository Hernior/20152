$(document).on('hidden.bs.modal', "#favorite", function(e){
    $("#content").load("favorites.php");
});
$(document).on('hidden.bs.modal', "#order", function(e){
    $("#content").load("orders.php");
});

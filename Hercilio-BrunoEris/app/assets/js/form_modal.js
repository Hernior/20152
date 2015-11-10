// Update Form Modal
$(document).on('click', "#submitModal", function(e){
    $('#atualizarDados').modal('hide');
    console.log('Execução hidemodal form_modal.js');
    $(document).on('hidden.bs.modal', "#atualizarDados", function(e){
        $("#content").load("profile.php");
        console.log('Execução .load form_modal.js');
    });
    return true;
});

// New Product Modal
$(document).on('click', "#submitNewProduct", function(e){
    $('#newProduct').modal('hide');
});

$(document).on('hidden.bs.modal', "#newProduct", function(e){
    $("#content").load("products.php");
});
// New Order Modal
// $(document).on('click', "#submitNewOrder", function(e){
//     $('#NewOrder').modal('hide');
// })
// $(document).on('hidden.bs.modal', "#NewOrder", function(e){
//     $("#content").load("newOrder.php");
// })

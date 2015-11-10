//$(document).on('submit', '#formAjax', function(){
$(document).ready(function() {
var DEBUG = (function(){
    var timestamp = function(){};
    timestamp.toString = function(){
        return "[DEBUG " + (new Date).toLocaleTimeString() + "]";
    };

    return {
        log: console.log.bind(console, '%s', timestamp)
    }
})();
DEBUG.log('Form.js');
var options = {
    target:        '#output',   // target element(s) to be updated with server response
    beforeSubmit:  showRequest,  // pre-submit callback
    success:       showResponse  // post-submit callback
};

var photoSettings = {
    target:        '#outputPhoto',   // target element(s) to be updated with server response
    beforeSubmit:  showRequest,  // pre-submit callback
    success:       showResponsePhoto  // post-submit callback
};

var orderSettings = {
    target:        '#output',   // target element(s) to be updated with server response
    beforeSubmit:  showRequest,  // pre-submit callback
    success:       showResponseOrder  // post-submit callback
};
$('#formAjax').ajaxForm(options);
$('#formPhoto').ajaxForm(photoSettings);
$('#formOrder').ajaxForm(orderSettings);

});

// pre-submit callback
function showResponseOrder(responseText, statusText, xhr, $form)  {
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").alert('close');
        console.log('Order Alert');
    });
    $('#orderSuccess').on('closed.bs.alert', function (e) {
        $("#content").load("orders.php");
        console.log('Order success response.');
    });
}
// pre-submit callback
function showResponsePhoto(responseText, statusText, xhr, $form)  {
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").alert('close');
        console.log('Photo Alert');
    });
    $('#atualizarFoto').on('closed.bs.alert', function (e) {
        $(location).attr('href',"main.php");
        // $("#content").load("profile.php");
        console.log('Photo Load');
    })
}
// pre-submit callback
function showRequest(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {
}

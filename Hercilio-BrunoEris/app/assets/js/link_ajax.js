$(document).on('click', ".link_ajax", function(){
	var link = $(this).attr("href");
	if(link != "#"){
	    $("#content").load(link, function( response, status, xhr ) {
			if ( status == "error" ) {
				$("#content").html("Erro: "+link+" "+xhr.statusText+" ("+xhr.status+")");
			}
			else{
				if (!$(".navbar-toggle").hasClass("collapsed")) {
			        $('.navbar-toggle').click() //bootstrap 3.x by Richard
			    }
				$(".dropdown.open").removeClass("open");
			}
		});
	}
	else{
		console.log("Link #");
	}
	return false;
});

jQuery(document).ready(function($){
	var sortList = $('ul#custom-type-list');
	var animation = $('#loading-animation');
	var pageTitle = $('#job-sort h2');
	sortList.sortable({
		
		update: function(event, ui){
			animation.show();
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'save_sort',
					order: sortList.sortable('toArray'),
					security: WP_WORK_LISTING.security
				},
				success: function( response ){
					$('div#message').remove();
					//console.log(sortList.sortable('toArray'));
					animation.hide();
					if(true == response.success){
						pageTitle.after('<div id="message" class="updated"> <p>' + WP_WORK_LISTING.success + '</p> </div>');
					}else{
						pageTitle.after('<div id="message"  style="color:red;"  class="error"> <p>'+WP_WORK_LISTING.failure+'</p> </div>');
					}
					
					
				},
				error: function( error ){
					$('div#message').remove();
					animation.hide();
					
				}
				
			});
		}
		
	});
	
});
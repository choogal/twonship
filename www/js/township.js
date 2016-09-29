
$( document ).ready(function() {
	$('#create_recipe').click(function (event) {
		event.preventDefault();
		
		amount = 		$('#new_amount').val();
		fk_recipe_id = 	$('#new_fk_recipe_id').val();
		fk_items_id = 	$(this).attr('data-fkitemsid');
		recipe_name = $('#new_fk_recipe_id option:selected').html();

		$.post(
			window.location.pathname,
			{
				amount			: amount,
				fk_recipe_id	: fk_recipe_id,
				fk_items_id		: fk_items_id,
				action_type		: 'save_recipe',
				ajax	: true
			},
		
			function (resultSet) {
				
				if (resultSet.successful) {
					//console.log($('li.send_recipe').length);
					
					html_li = '<li class="del_recipe list-group-item"><ul><li>Ingrediente: '+recipe_name+'</li><li>Cantidad: '+amount+'</li></ul><input class="delete_recipe" data-id="'+resultSet.id+'" type="button" value="Borrar"></li>';
					//console.log(html_li);
					$('ul#list_recipes').append(html_li);
					
					$('#new_amount').val('1');
					$('#new_fk_recipe_id').val('');

				}
			}
		);
	});

	$('input.delete_recipe').click(function(event) {
		event.preventDefault();
		
		elem = $(this);
		id = $(this).attr('data-id');
		
		$.post(
			window.location.pathname,
			{
				id			: id,
				action_type	: 'delete_recipe',
				ajax		: true
			},
		
			function (resultSet) {
				//console.log(resultSet);
				if (resultSet == 'OK') {
					elem.parent().remove();
				}
			}
		);
	});


	$("button.btn-delete-prod").confirm({
		text: "Desea borrar este producto?",
		title: "Confirmar borrado",
		confirm: function(button) {
			
			id = button.attr('data-id');
			//console.log(id);
		
			$.post(
				'item.html',
				{
					id			: id,
					action_type	: 'delete_item',
					ajax		: true
				},
			
				function (resultSet) {
					//console.log(resultSet);
					if (resultSet == 'OK') {
						$('tr#tr_'+id).remove();
					}
				}
			);
	},
	cancel: function(button) {
	// nothing to do
	},
	confirmButton: "Sí",
	cancelButton: "No",
	post: true,
	confirmButtonClass: "btn-danger",
	cancelButtonClass: "btn-default",
	dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
	});
	/*$('button.btn-delete-prod').click(function(event) {
		event.preventDefault();
		
		id = $(this).attr('data-id');
		console.log(id);
		
			$.post(
				'item.html',
				{
					id			: id,
					action_type	: 'delete_item',
					ajax		: true
				},
			
				function (resultSet) {
					//console.log(resultSet);
					if (resultSet == 'OK') {
						$('tr#tr_'+id).remove();
					}
				}
			);
		}
	});*/
});
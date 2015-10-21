/*
 * Admin Scripts File
 * Author: Matthew Stumphy
 *
 * Just any extra javascript to run in the admin area.
*/


jQuery(document).ready(function($) {
	toggleMetaboxes($);
	$('#page_template').change(function() {
		toggleMetaboxes($);
	});
});

function toggleMetaboxes($) {
	var pageTemplate = $('#page_template').val()
	if (pageTemplate == 'page-index-grid.php' ) {
		$('#_skinsplex_index_grid_metabox').show();
	} else {
		$('#_skinsplex_index_grid_metabox').hide();
	}
}

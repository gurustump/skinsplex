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
	
	toggleAdType($, $('#_skinsplex_ad_space_group_repeat .cmb2_select'));
	$('#_skinsplex_ad_space_group_repeat').on('change','.cmb2_select', function() {
		toggleAdType($, $(this));
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

function toggleAdType($, select) {
	select.each(function(k,v) {
		var selection = $(this).val() == 'image' ? '.cmb-type-textarea-code' : '.cmb-type-file, .cmb-type-textarea-small, .cmb-type-text-url';
		$(this).closest('.cmb-field-list').find('.cmb-row').show();
		$(this).closest('.cmb-field-list').find(selection).hide();
	});
}
<form role="search" method="get" id="searchform" class="search-form top-nav-hidden-form TOP_NAV_SEARCH_FORM OV" action="<?php echo home_url( '/' ); ?>">
    <div>
        <input type="search" id="s" name="s" value="" placeholder="Search" />
		<input type="hidden" name="post_type" value="media_items" />
        <button class="btn" type="submit" id="searchsubmit" ><?php _e('Search','bonestheme'); ?></button>
		<a href="#" class="btn-close OV_CLOSE">Close</a>
    </div>
</form>
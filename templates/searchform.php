<form role="search" class="form" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
	<div class="input-group">
		<input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="form-control" placeholder="<?php _e('Search', 'shoestrap'); ?> <?php bloginfo('name'); ?>">
		<span class="input-group-btn">
			<button type="submit" id="searchsubmit" class="btn btn-default"><i class="el-icon-search"></i></button>
		</span>
	</div>
</form>
<?php

// Located in header.php
// Just before anything else, it loads all the neccesary elements for the <head> section
function thematic_head() {
    do_action('thematic_head');
}

// Located in header.php 
// Just after the opening body tag, before anything else.
function thematic_before() {
    do_action('thematic_before');
}

// Located in header.php 
// Just before the header div
function thematic_aboveheader() {
    do_action('thematic_aboveheader');
}

// Located in header.php 
// Just after the header div
function thematic_belowheader() {
    do_action('thematic_belowheader');
}

// Located in sidebar.php 
// Just before the main asides (commonly used as sidebars)
function thematic_abovemainasides() {
    do_action('thematic_abovemainasides');
}

// Located in sidebar.php 
// Between the main asides (commonly used as sidebars)
function thematic_betweenmainasides() {
    do_action('thematic_betweenmainasides');
}

// Located in sidebar.php 
// after the main asides (commonly used as sidebars)
function thematic_belowmainasides() {
    do_action('thematic_belowmainasides');
}

// Located in footer.php
// Just before the footer div
function thematic_abovefooter() {
    do_action('thematic_abovefooter');
}

// Located in footer.php
// Just after the footer div
function thematic_belowfooter() {
    do_action('thematic_belowfooter');
}

// Located in footer.php 
// Just before the closing body tag, after everything else.
function thematic_after() {
    do_action('thematic_after');
}

// Creates the content of the Title tag
// Credits: Tarski Theme
function thematic_doctitle() {

    $site_name = get_bloginfo('name');
    $separator = '|';
        	
    if ( is_single() ) {
      $content = single_post_title('', FALSE);
    }
    elseif ( is_home() || is_front_page() ) { 
      $content = get_bloginfo('description');
    }
    elseif ( is_page() ) { 
      $content = single_post_title('', FALSE); 
    }
    elseif ( is_search() ) { 
      $content = __('Search Results for:', 'thematic'); 
      $content .= ' ' . wp_specialchars(stripslashes(get_search_query()), true);
    }
    elseif ( is_tag() ) { 
      $content = __('Tag Archives:', 'thematic');
      $content .= ' ' . thematic_tag_query();
    }
    elseif ( is_404() ) { 
      $content = __('Not Found', 'thematic'); 
    }
    else { 
      $content = get_bloginfo('description');
    }

    if (get_query_var('paged')) {
      $content .= ' ' .$separator. ' ';
      $content .= 'Page';
      $content .= ' ';
      $content .= get_query_var('paged');
    }

    if($content) {
      $elements = array(
        'site_name' => $site_name,
        'separator' => $separator,
        'content' => $content
      );
    } else {
      $elements = array(
        'site_name' => $site_name
      );
    }

    // Filters should return an array
    $elements = apply_filters('thematic_doctitle', $elements);
	
    // But if they don't, it won't try to implode
    if(is_array($elements)) {
      $doctitle = implode(' ', $elements);
    }
    else {
      $doctitle = $elements;
    }
      
    echo $doctitle;

}

// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
function thematic_add_menuclass($ulclass) {
return preg_replace('/<ul>/', '<ul id="nav" class="sf-menu">', $ulclass, 1);
}
add_filter('wp_page_menu','thematic_add_menuclass');

/*
Here's how to filter your menu now.

function sample_nav() { ?>
    <div class="menu">
        <ul>
            <li><a href="#">Oh</a></li>
            <li><a href="#">Hello there!</a></li>
        </ul>
    </div><!-- .menu -->     
<?php }
add_filter('wp_page_menu', 'sample_nav');

*/

// Filter to create the time url title displayed in Post Header
function thematic_time_title() {

  $time_title = 'Y-m-d\TH:i:sO';

	// Filters should return correct 
	$time_title = apply_filters('thematic_time_title', $time_title);
	
	return $time_title;
}

// Filter to create the time displayed in Post Header
function thematic_time_display() {

  $time_display = 'F j, Y';

	// Filters should return correct 
	$time_display = apply_filters('thematic_time_display', $time_display);
	
	return $time_display;
}


// Filter to create create the sidebar
function thematic_sidebar() {

  $show = TRUE;

	// Filters should return Boolean 
	$show = apply_filters('thematic_sidebar', $show);
	
	if ($show) {
    get_sidebar();}
	
	return;
}

// Information in Post Header
function thematic_postheader() {
    global $id, $post, $authordata;
    
    // Create $posteditlink    
    $posteditlink .= '<a href="' . get_bloginfo('wpurl') . '/wp-admin/post.php?action=edit&amp;post=' . $id;
    $posteditlink .= '" title="' . __('Edit post', 'thematic') .'">';
    $posteditlink .= __('Edit', 'thematic') . '</a>';

    
    if (is_single() || is_page()) {
        $posttitle = '<h1 class="entry-title">' . get_the_title() . "</h1>\n";
    } elseif (is_404()) {    
        $posttitle = '<h1 class="entry-title">' . __('Not Found', 'thematic') . "</h1>\n";
    } else {
        $posttitle = '<h2 class="entry-title"><a href="';
        $posttitle .= get_permalink();
        $posttitle .= '" title="';
        $posttitle .= __('Permalink to ', 'thematic') . the_title_attribute('echo=0');
        $posttitle .= '" rel="bookmark">';
        $posttitle .= get_the_title();   
        $posttitle .= "</a></h2>\n";
    }
    
    $postmeta = '<div class="entry-meta">';
    $postmeta .= '<span class="author vcard">';
    $postmeta .= __('By ', 'thematic') . '<a class="url fn n" href="';
    $postmeta .= get_author_link(false, $authordata->ID, $authordata->user_nicename);
    $postmeta .= '" title="' . __('View all posts by ', 'thematic') . get_the_author() . '">';
    $postmeta .= get_the_author();
    $postmeta .= '</a></span><span class="meta-sep"> | </span>';
    $postmeta .= __('Published: ', 'thematic');
    $postmeta .= '<span class="entry-date"><abbr class="published" title="';
    $postmeta .= get_the_time(thematic_time_title()) . '">';
    $postmeta .= get_the_time(thematic_time_display());
    $postmeta .= '</abbr></span>';
    // Display edit link
    if (current_user_can('edit_posts')) {
        $postmeta .= ' <span class="meta-sep">|</span> ' . $posteditlink;
    }               
    $postmeta .= "</div><!-- .entry-meta -->\n";

    
    if ($post->post_type == 'page' || is_404()) {
        $postheader = $posttitle;        
    } else {
        $postheader = $posttitle . $postmeta;    
    }
    
    echo apply_filters( 'thematic_postheader', $postheader ); // Filter to override default post header
}

// Information in Post Footer
function thematic_postfooter() {
    global $id, $post;

    // Create $posteditlink    
    $posteditlink .= '<a href="' . get_bloginfo('wpurl') . '/wp-admin/post.php?action=edit&amp;post=' . $id;
    $posteditlink .= '" title="' . __('Edit post', 'thematic') .'">';
    $posteditlink .= __('Edit', 'thematic') . '</a>';
    
    // Display the post categories  
    $postcategory = '<div class="entry-utility">';
    $postcategory .= '<span class="cat-links">';
    if (is_single()) {
        $postcategory .= __('This entry was posted in ', 'thematic') . get_the_category_list(', ');
        $postcategory .= '</span>';
    } elseif ( is_category() && $cats_meow = thematic_cats_meow(', ') ) { /* Returns categories other than the one queried */
        $postcategory .= __('Also posted in ', 'thematic') . $cats_meow;
        $postcategory .= '</span> <span class="meta-sep">|</span>';
    } else {
        $postcategory .= __('Posted in ', 'thematic') . get_the_category_list(', ');
        $postcategory .= '</span> <span class="meta-sep">|</span>';
    }
    
    // Display the tags
    if (is_single()) {
        $tagtext = __(' and tagged', 'thematic');
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span>');
    } elseif ( is_tag() && $tag_ur_it = thematic_tag_ur_it(', ') ) { /* Returns tags other than the one queried */
        $posttags = '<span class="tag-links">' . __(' Also tagged ', 'thematic') . $tag_ur_it . '</span> <span class="meta-sep">|</span>';
    } else {
        $tagtext = __('Tagged', 'thematic');
        $posttags = get_the_tag_list("<span class=\"tag-links\"> $tagtext ",', ','</span> <span class="meta-sep">|</span>');
    }
    
    // Display comments link and edit link
    if (comments_open()) {
        $postcommentnumber = get_comments_number();
        if ($postcommentnumber > '1') {
            $postcomments = ' <span class="comments-link"><a href="' . get_permalink() . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= get_comments_number() . __(' Comments', 'thematic') . '</a></span>';
        } elseif ($postcommentnumber == '1') {
            $postcomments = ' <span class="comments-link"><a href="' . get_permalink() . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= get_comments_number() . __(' Comment', 'thematic') . '</a></span>';
        } elseif ($postcommentnumber == '0') {
            $postcomments = ' <span class="comments-link"><a href="' . get_permalink() . '#comments" title="' . __('Comment on ', 'thematic') . the_title_attribute('echo=0') . '">';
            $postcomments .= __('Leave a comment', 'thematic') . '</a></span>';
        }
    } else {
        $postcomments = ' <span class="comments-link">' . __('Comments closed', 'thematic') .'</span>';
    }
    // Display edit link
    if (current_user_can('edit_posts')) {
        $postcomments .= ' <span class="meta-sep">|</span> ' . $posteditlink;
    }               
    
    // Display permalink, comments link, and RSS on single posts
    $postconnect .= __('. Bookmark the ', 'thematic') . '<a href="' . get_permalink() . '" title="' . __('Permalink to ', 'thematic') . the_title_attribute('echo=0') . '">';
    $postconnect .= __('permalink', 'thematic') . '</a>.';
    if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) { /* Comments are open */
        $postconnect .= ' <a class="comment-link" href="#respond" title ="' . __('Post a comment', 'thematic') . '">' . __('Post a comment', 'thematic') . '</a>';
        $postconnect .= __(' or leave a trackback: ', 'thematic');
        $postconnect .= '<a class="trackback-link" href="' . trackback_url(FALSE) . '" title ="' . __('Trackback URL for your post', 'thematic') . '" rel="trackback">' . __('Trackback URL', 'thematic') . '</a>.';
    } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) { /* Only trackbacks are open */
        $postconnect .= __(' Comments are closed, but you can leave a trackback: ', 'thematic');
        $postconnect .= '<a class="trackback-link" href="' . trackback_url(FALSE) . '" title ="' . __('Trackback URL for your post', 'thematic') . '" rel="trackback">' . __('Trackback URL', 'thematic') . '</a>.';
    } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) { /* Only comments open */
        $postconnect .= __(' Trackbacks are closed, but you can ', 'thematic');
        $postconnect .= '<a class="comment-link" href="#respond" title ="' . __('Post a comment', 'thematic') . '">' . __('post a comment', 'thematic') . '</a>.';
    } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) { /* Comments and trackbacks closed */
        $postconnect .= __(' Both comments and trackbacks are currently closed.', 'thematic');
    }
    // Display edit link on single posts
    if (current_user_can('edit_posts')) {
        $postconnect .= ' ' . $posteditlink;
    }
    
    // Add it all up
    if ($post->post_type == 'page' && current_user_can('edit_posts')) { /* For logged-in "page" search results */
        $postfooter = '<div class="entry-utility">' . $posteditlink;
        $postfooter .= "</div><!-- .entry-utility -->\n";    
    } elseif ($post->post_type == 'page') { /* For logged-out "page" search results */
        $postfooter = '';
    } else {
        if (is_single()) {
            $postfooter = $postcategory . $posttags . $postconnect;
        } else {
            $postfooter = $postcategory . $posttags . $postcomments;
        }
        $postfooter .= "</div><!-- .entry-utility -->\n";    
    }
    
    // Put it on the screen
    echo apply_filters( 'thematic_postfooter', $postfooter ); // Filter to override default post footer
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function thematic_cats_meow($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;

	return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function thematic_tag_ur_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;

	return trim(join( $glue, $tags ));
}

// Produces an avatar image with the hCard-compliant photo class
function thematic_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '80' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

?>
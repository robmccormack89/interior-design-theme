<?php
/**
 * Theme functions & bits
 *
 * @package Shanley_Theme
 */

// get the current year, this is passed onto twig as a global variable in timber-functions.php
function currentYear()
{
    return date('Y');
}

// // remove sticky from main query
// // this is key!
// add_action('pre_get_posts', 'wpse74620_ignore_sticky');
// // the function that does the work
// function wpse74620_ignore_sticky($query)
// {
//     // sure we're were we want to be.
//     if ($query->is_main_query() || $query->is_category())
//         $query->set('ignore_sticky_posts', true);
// }

// Remove tags support from posts
function myprefix_unregister_tags() {
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');

// 
function is_no_sidebar_template_width_class()
{
  if (is_page_template('page-templates/no-sidebar-template.php')) {
      return 'uk-width-1-1';
  } else {
      return 'uk-width-2-3@m';
  };
}

// 
function if_posts_published_more_than_one()
{
  if( wp_count_posts()->publish > 1 ) :
      return true;
  else:
      return false;
  endif;
}

// 
function if_posts_more_than_one_return_class()
{
  if( wp_count_posts()->publish > 1 ) :
      return 'posts-exists';
  else:
      return '';
  endif;
}

// 
function is_left_sidebar_template()
{
  if (is_page_template('page-templates/left-sidebar-template.php')) {
    return true;
  } else {
    return false;
  };
}

// 
function is_right_sidebar_template()
{
  if (is_single() || is_page() && ! is_page_template(array( 'page-templates/left-sidebar-template.php', 'page-templates/no-sidebar-template.php' ))) {
    return true;
  } else {
    return false;
  };
}

// check for if the archive is paginated, for use in templates to conditionally display the pagi block
function is_paginated()
{
    global $wp_query;
    if ($wp_query->max_num_pages > 1) {
        return true;
    } else {
        return false;
    }
}
// removes sticky posts from main loop, this function fixes issue of duplicate posts on archive. see https://wordpress.stackexchange.com/questions/225015/sticky-post-from-page-2-and-on
add_action('pre_get_posts', function ($q) {
    if ($q->is_home()       // Only target the homepage
         && $q->is_main_query() // Only target the main query
    ) {
        // Remove sticky posts
        $q->set('ignore_sticky_posts', 1);

        // Get the sticky posts array
        $stickies = get_option('sticky_posts');

        // Make sure we have stickies before continuing, else, bail
        if (!$stickies) {
            return;
        }

        // Great, we have stickies, lets continue
        // Lets remove the stickies from the main query
        $q->set('post__not_in', $stickies);

        // Lets add the stickies to page one via the_posts filter
        if ($q->is_paged()) {
            return;
        }

        add_filter('the_posts', function ($posts, $q) use ($stickies) {
            // Make sure we only target the main query
            if (!$q->is_main_query()) {
                return $posts;
            }

            // Get the sticky posts
            $args = [
                'posts_per_page' => count($stickies),
                'post__in'       => $stickies
            ];
            $sticky_posts = get_posts($args);

            // Lets add the sticky posts in front of our normal posts
            $posts = array_merge($sticky_posts, $posts);

            return $posts;
        }, 10, 2);
    }
});

// stuff to say we need timber activated!! see TGM Plugin activation library
function shanley_theme_register_required_plugins()
{
    $plugins = array(
        array(
            'name' => 'Timber',
            'slug' => 'timber-library',
            'required' => true
        )
    );
    $config  = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug' => 'themes.php', // Parent menu slug.
        'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '' // Message to output right before the plugins table.
    );
    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'shanley_theme_register_required_plugins');

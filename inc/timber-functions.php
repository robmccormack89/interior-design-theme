<?php
/**
 * Timber theme class & other functions for Twig.
 *
 * @package Shanley_Theme
 */

// Define paths to Twig templates
Timber::$dirname = array(
  'views/',
  'views/archive',
  'views/parts',
  'views/parts/comments',
  'views/parts/sidebars',
  'views/parts/tease',
  'views/singular',
);

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class ShanleyTheme extends Timber\Site
{
  
    /** Add timber support. */
    public function __construct()
    {
        // timber stuff
        add_action('after_setup_theme', array( $this, 'theme_supports' ));
        add_action('wp_enqueue_scripts', array( $this, 'shanley_theme_enqueue_assets'));
        add_action('widgets_init', array( $this, 'shanley_custom_uikit_widgets_init'));
        add_filter('timber/context', array( $this, 'add_to_context' ));
        add_filter('timber/twig', array( $this, 'add_to_twig' ));
        add_action('init', array( $this, 'register_post_types' ));
        add_action('init', array( $this, 'register_taxonomies' ));
        add_action('init', array( $this, 'register_widget_areas' ));
        add_action('init', array( $this, 'register_navigation_menus' ));
        parent::__construct();
    }

    public function register_post_types()
    {
    }

    public function register_taxonomies()
    {
        // Register Custom Taxonomy
    }

    public function register_widget_areas()
    {
        // Register widget areas
        if (function_exists('register_sidebar')) {
            register_sidebar(array(
              'name' => esc_html__('Left Sidebar Area', 'shanley-theme'),
              'id' => 'sidebar-left',
              'description' => esc_html__('Sidebar Area for Left Sidebar Templates, you can add multiple widgets here.', 'shanley-theme'),
              'before_widget' => '',
              'after_widget' => '',
              'before_title' => '<h3 class="uk-heading-line uk-text-bold widget-title"><span>',
              'after_title' => '</span></h3>'
          ));
            register_sidebar(array(
                'name' => esc_html__('Right Sidebar Area', 'shanley-theme'),
                'id' => 'sidebar-right',
                'description' => esc_html__('Sidebar Area for Right Sidebar Templates, you can add multiple widgets here.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="uk-heading-line uk-text-bold widget-title"><span>',
                'after_title' => '</span></h3>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Header Top Area', 'shanley-theme'),
                'id' => 'sidebar-header-top',
                'description' => esc_html__('Header Top Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h4 class="widget-title" hidden>',
                'after_title' => '</h4>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Bottom Footer Area', 'shanley-theme'),
                'id' => 'sidebar-footer-bottom',
                'description' => esc_html__('Bottom Footer Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h4 class="widget-title" hidden>',
                'after_title' => '</h4>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Footer One Area', 'shanley-theme'),
                'id' => 'sidebar-footer-one',
                'description' => esc_html__('Footer One Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Footer Two Area', 'shanley-theme'),
                'id' => 'sidebar-footer-two',
                'description' => esc_html__('Footer Two Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Footer Three Area', 'shanley-theme'),
                'id' => 'sidebar-footer-three',
                'description' => esc_html__('Footer Three Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Footer Four Area', 'shanley-theme'),
                'id' => 'sidebar-footer-four',
                'description' => esc_html__('Footer Four Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            ));
            
            
            register_sidebar(array(
                'name' => esc_html__('Home Dark One Area', 'shanley-theme'),
                'id' => 'sidebar-home-one',
                'description' => esc_html__('Home Dark One Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title" hidden>',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => esc_html__('Home Dark Two Area', 'shanley-theme'),
                'id' => 'sidebar-home-two',
                'description' => esc_html__('Home Dark Two Widget Area; works best with the 1 Custom UiKit HTML Widget.', 'shanley-theme'),
                'before_widget' => '',
                'after_widget' => '',
                'before_title' => '<h3 class="widget-title" hidden>',
                'after_title' => '</h3>'
            ));
            

        }
    }

    public function register_navigation_menus()
    {
        // This theme uses wp_nav_menu() in one locations.
        register_nav_menus(array(
            'main' => __('Main Menu', 'shanley-theme'),
            'mobile' => __('Mobile Menu', 'shanley-theme'),
        ));
    }

    public function add_to_context($context)
    {
        // optional args for Timber/Menu below. see options https://timber.github.io/docs/guides/menus/
        $main_menu_args = array(
          'depth' => 3,
        );
        // Initializing our menus
        $context['menu_main'] = new Timber\Menu('main');
        $context['menu_mobile'] = new Timber\Menu('mobile');
      
        // check for whether a menu exists
        $context['has_menu_main'] = has_nav_menu('main');
        $context['has_menu_mobile'] = has_nav_menu('mobile');
      
        //add the site data to the context globally
        $context['site'] = $this;
      
        // check if archive is paginated, see theme-functions.php
        $context['is_paginated'] = is_paginated();
      
        // get the current year, see theme-functions.php
        $context['current_year'] =  currentYear();
       
        // get the theme logo id
        $theme_logo_id = get_theme_mod('custom_logo');
        // get the theme logo url via the theme logo id
        $theme_logo_url = wp_get_attachment_image_url($theme_logo_id, 'full');
        // add theme logo url to the context
        $context['theme_logo_url'] = $theme_logo_url;
      
        // add sidebars to them context
        $context['sidebar_left']  = Timber::get_widgets('Left Sidebar Area');
        $context['sidebar_right'] = Timber::get_widgets('Right Sidebar Area');
        
        $context['sidebar_home_one']  = Timber::get_widgets('Home Dark One Area');
        $context['sidebar_home_two'] = Timber::get_widgets('Home Dark Two Area');
        
        $context['sidebar_header_top'] = Timber::get_widgets('Header Top Area');
        
        $context['sidebar_footer_bottom'] = Timber::get_widgets('Bottom Footer Area');
        $context['sidebar_footer_one'] = Timber::get_widgets('Footer One Area');
        $context['sidebar_footer_two'] = Timber::get_widgets('Footer Two Area');
        $context['sidebar_footer_three'] = Timber::get_widgets('Footer Three Area');
        $context['sidebar_footer_four'] = Timber::get_widgets('Footer Four Area');
      
        // if page template being used is no-sidebar, article width class sets to 1-1, otherwise its 2-3@s. theme-functions.php
        $context['article_width_class'] = is_no_sidebar_template_width_class();
      
        // checks for: if is left sidebar template, if is right sidebar templates. theme-functions.php
        $context['is_left_sidebar'] = is_left_sidebar_template();
        $context['is_right_sidebar'] = is_right_sidebar_template();
        
        $context['if_posts_more_than_one'] = if_posts_published_more_than_one();
        
        $context['posts_more_than_one_class'] = if_posts_more_than_one_return_class();

        return $context;
    }
    
    public function theme_supports()
    {

      // theme support for title tag
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('post-formats', array(
          'gallery',
          'quote',
          'video',
          'aside',
          'image',
          'link'
        ));
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('woocommerce');

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support('html5', array(
          'search-form',
          'comment-form',
          'comment-list',
          'gallery',
          'caption'
        ));

        // Add support for core custom logo.
        add_theme_support('custom-logo', array(
          'height' => 30,
          'width' => 261,
          'flex-width' => true,
          'flex-height' => true
        ));

        // add custom thumbs sizes.
        add_image_size('shanley-theme-featured-image-archive', 800, 300, true);
        add_image_size('shanley-theme-hero-image', 951, 489, true);
        add_image_size('shanley-theme-post-slider-image', 600, 600, true);
        
        load_theme_textdomain( 'shanley-wp-theme', get_template_directory() . '/languages' );
    }
    
    public function shanley_theme_enqueue_assets()
    {
        // load infinite scroll on archive pages
        if (is_home() || is_archive() || is_search()) {
            wp_enqueue_style('shanley-theme-css', get_template_directory_uri() . '/assets/css/base.css');
            wp_enqueue_script('shanley-theme-js', get_template_directory_uri() . '/assets/js/main/main_scroll.js', '', '', false);
            wp_enqueue_style('shanley-theme-styles', get_stylesheet_uri());
        } else {
            wp_enqueue_style('shanley-theme-css', get_template_directory_uri() . '/assets/css/base.css');
            wp_enqueue_script('shanley-theme-js', get_template_directory_uri() . '/assets/js/main/main.js', '', '', false);
            wp_enqueue_style('shanley-theme-styles', get_stylesheet_uri());
        }
    }
    
    public function shanley_custom_uikit_widgets_init()
    {
        register_widget("Shanley_Theme_Custom_UIKIT_Widget_Class");
    }

    public function add_to_twig($twig)
    {
        /* this is where you can add your own functions to twig */
        $twig->addExtension(new Twig_Extension_StringLoader());

        return $twig;
    }
}

new ShanleyTheme();

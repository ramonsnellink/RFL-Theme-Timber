<?php

namespace Jackpine;

use Timber\Menu;
use Timber\Site;
use Timber\Timber;
use Twig\Environment;
use WPackio\Enqueue;

/**
 * Class JackpineSite
 *
 * @package WordPress
 * @subpackage Jackpine
 * @since Jackpine 0.1.0
 */
class JackpineSite extends Site {
    /**
     * @var Enqueue
     */
    protected $wpackInstance;

    /**
     * @var Timber
     */
    protected $timberInstance;

    /**
     * JackpineSite constructor.
     *
     * @param string $themeName The name of the application in the wpackio.project.js config
     * @param string $themeVersion The version of the theme
     * @param string $distPath The path to wpack.io dist folder
     * @param string $templatesPath The path to templates folder
     */
    public function __construct( string $themeName, string $themeVersion, string $distPath, string $templatesPath ) {
        $this->wpackInstance  = new Enqueue( $themeName, $distPath, $themeVersion, 'theme', false );
        $this->timberInstance = new Timber();

        Timber::$dirname = $templatesPath;

        $this->add_actions();
        $this->add_filters();

        parent::__construct();
    }

    /**
     * Register our actions.
     */
    public function add_actions() {
        add_action( 'after_setup_theme', [ $this, 'add_theme_supports' ] );
        add_action( 'after_setup_theme', [ $this, 'load_text_domain' ] );
        add_action( 'init', [ $this, 'add_custom_taxonomies' ] );
        add_action( 'init', [ $this, 'add_custom_post_types' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_wpack_scripts' ] );
        add_action( 'acf/init', [$this, 'my_acf_init' ] );
        add_action( 'after_setup_theme', [$this, 'add_gutenberg_css'] );
        add_action( 'wp_enqueue_scripts', [$this, 'google_fonts' ] );
     
        
    }
    /**
     * Register our filters.
     */
    public function add_filters() {
        add_filter( 'timber/context', [ $this, 'add_to_context' ] );
        add_filter( 'timber/twig', [ $this, 'add_to_twig' ] );
        add_filter( 'wp_enqueue_scripts', [$this, 'change_default_jquery'], PHP_INT_MAX );

     
    }

   public  function change_default_jquery( ){
        wp_dequeue_script( 'jquery');
        wp_deregister_script( 'jquery');   
    }




       /**
     * Register ACF Blocks
     */
    public function my_acf_init() {
        // Bail out if function doesn’t exist.
        if ( ! function_exists( 'acf_register_block' ) ) {
            return;
        }
    
        // Register a new block.
        acf_register_block( array(
            'name'            => 'example_block',
            'title'           => __( 'Example Block', 'jackpine' ),
            'description'     => __( 'A custom example block.', 'jackpine' ),
            'render_callback' => [$this, 'my_acf_block_render_callback'],
            'category'        => 'formatting',
            'icon'            => 'admin-comments',
            'keywords'        => array( 'example' ),
        ) );
    }


    /**
 *  This is the callback that displays the block.
 *
 * @param   array  $block      The block settings and attributes.
 * @param   string $content    The block content (emtpy string).
 * @param   bool   $is_preview True during AJAX preview.
 */
    public function my_acf_block_render_callback( $block, $content = '', $is_preview = false ) {
        $context = Timber::context();

        // Store block values.
        $context['block'] = $block;

        // Store field values.
        $context['fields'] = get_fields();

        // Store $is_preview value.
        $context['is_preview'] = $is_preview;

        // Render the block.
        Timber::render( 'blocks/example-block.twig', $context );
    }

    /**
     * Register custom taxonomies.
     */
    public function add_custom_taxonomies() {
        //
    }

    /**
     * Register custom post types.
     */
    public function add_custom_post_types() {
        //
    }

 
    public function add_gutenberg_css(){
    
        add_theme_support( 'editor-styles' ); // if you don't add this line, your stylesheet won't be added
        add_editor_style( 'editor-style.css' ); // tries to include editor-style.css directly from your theme folder
    
}

    public function google_fonts() {
        wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap', false );
    }

    /**
     * Register supported theme features.
     */
    public function add_theme_supports() {
        // Enable RSS feeds for posts and comments
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress provide the document title
        add_theme_support( 'title-tag' );

        // Enable featured images for posts
        add_theme_support( 'post-thumbnails' );

        // Enable HTML5 markup for certain elements
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        // Enable menus
        add_theme_support( 'menus' );

        // Enable Logo
        add_theme_support('custom-logo', [
            'height'      => 74,
            'width'       => 350,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => ['site-title', 'site-description'],
            'unlink-homepage-logo' => false,

        ]);

        add_editor_style('style-editor.css'); // To add custom TinyMCE editor styles
        add_editor_style( 'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap' );

        add_theme_support('wp-block-styles');
        add_theme_support('align-wide'); // Full width and wide width for images
        

        add_theme_support('custom-background', [
            'default-color' => '#fff',
            'default-image' => '',
        ]);
    
    }

 

    /**
     * Add variables to the global Timber context.
     *
     * @param array $context The global Timber context
     *
     * @return array The modified global Timber context
     */
    public function add_to_context( array $context ) {
        $context['custom_logo_url'] = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
        $context['menu'] = new Menu();
        $context['site'] = $this;

        return $context;
    }

    /**
     * Add extensions to the Timber Twig environment.
     *
     * @param Environment $twig The Timber Twig environment
     *
     * @return Environment The modified Timber Twig environment
     */
    public function add_to_twig( Environment $twig ) {
        return $twig;
    }

    /**
     * Load the theme text domain.
     */
    public function load_text_domain() {
        load_theme_textdomain( 'jackpine',
            get_template_directory() . '/languages' );
    }

    /**
     * Load wpack.io scripts.
     */
    public function enqueue_wpack_scripts() {
        $this->wpackInstance->enqueue( 'app', 'main', [] );
    }
}

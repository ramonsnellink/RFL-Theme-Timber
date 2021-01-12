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
    }

    /**
     * Register our filters.
     */
    public function add_filters() {
        add_filter( 'timber/context', [ $this, 'add_to_context' ] );
        add_filter( 'timber/twig', [ $this, 'add_to_twig' ] );
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

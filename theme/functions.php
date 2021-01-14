<?php

/**
 * Jackpine
 *
 * Based on the Timber starter theme.
 * Huge thanks to the folks who made the tools that Jackpine is built on.
 *
 * @package WordPress
 * @subpackage Jackpine
 * @since Jackpine 0.1.0
 */

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use Jackpine\JackpineSite;

new JackpineSite( 'jackpine', '0.11.0', '../dist', '../assets/templates' );



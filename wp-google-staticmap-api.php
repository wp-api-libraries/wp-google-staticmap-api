<?php
/**
 * WP Google Staticmaps API (https://developers.google.com/maps/documentation/static-maps)
 *
 * @package WP-GoogleStaticMaps-API
 */

/*
* Plugin Name: WP GoogleStaticMaps API
* Plugin URI: https://github.com/wp-api-libraries/wp-google-staticmap-api
* Description: Perform API requests to Google Staticmaps API in WordPress.
* Author: WP API Libraries
* Author URI: https://wp-api-libraries.com
* Version: 1.0.0
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-google-staticmap-api
* GitHub Branch: master
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'GoogleStaticMapAPI' ) ) {

	/**
	 * GoogleStaticMapAPI class.
	 */
	class GoogleStaticMapAPI {

		 /**
		 * API Key.
		 *
		 * @var mixed
		 * @access private
		 * @static
		 */
		static private $api_key;

		/**
		 * Return format. XML or JSON.
		 *
		 * @var [string
		 */
	 	static private $output;

		/**
		 * Google GeoCode Base URI.
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://maps.googleapis.com/maps/api/staticmap';

		/**
		 * Construct.
		 *
		 * @access public
		 * @param mixed $apikey API Key.
		 * @param mixed $output Output.
		 * @return void
		 */
		public function __construct( $api_key, $output = 'json' ) {

			static::$api_key = $api_key;
			static::$output = $output;

		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}

		/**
		 * Get Static Map.
		 *
		 * @access public
		 * @param mixed $center
		 * @param mixed $zoom
		 * @param mixed $size
		 * @param mixed $scale
		 * @param mixed $format
		 * @param mixed $maptype
		 * @param mixed $language
		 * @param mixed $region
		 * @param mixed $markers
		 * @param mixed $path
		 * @param mixed $visible
		 * @param mixed $style
		 * @param mixed $signature
		 * @return void
		 */
		function get_map( $center, $zoom, $size, $scale, $format, $maptype, $language, $region, $markers, $path, $visible, $style, $signature = '' ) {

			$request = $this->base_uri . '?center=' . $center . '&zoom=' . $zoom . '&size=' . $size . '&scale=' . $scale . '&format=' . $format . '&maptype=' . $maptype . '&language=' . $language . '&markers=' . $markers . '&path=' . $path . '&visible=' . $visible . '&style=' . $style . '&key=' . static::$api_key;

			return $this->fetch( esc_url( $request ) );

		}

	}
}
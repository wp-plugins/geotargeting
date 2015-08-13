<?php
/**
 * Functions for geotargeting
 *
 * @link       http://wp.timersys.com/geotargeting/
 * @since      1.0.0
 *
 * @package    GeoTarget
 * @subpackage GeoTarget/includes
 * @author     Your Name <email@example.com>
 */
use GeoIp2\Database\Reader;

class GeoTarget_Functions {

	/**
	 * Current user country used everywhere
	 * @var string
	 */
	protected  $userCountry;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct( ) {

			add_action('init' , array($this,'setUserCountry' ) );

	}

	function setUserCountry() {
		if( !is_admin()
		    && ! defined('DOING_CRON')
		    && ! defined('DOING_AJAX') )
			$this->userCountry = apply_filters('geot/user_country', $this->calculateUserCountry());
	}

	/**
	 * Main function that return is user target the given countries / regions or not
	 * @param  string $country         
	 * @param  string $region          
	 * @param  string $exclude_country 
	 * @param  string $exclude_region  
	 * @return bool      
	 */
	public function target( $country = '', $region = '', $exclude_country = '', $exclude_region  = '')
	{

		//Push country list into array
		$country 			= $this->toArray( $country );
		
		$exclude_country 	= $this->toArray( $exclude_country );
				
		$saved_regions 		= apply_filters('geot/get_regions', array());

		//Append any regions
		if ( !empty( $region ) && ! empty( $saved_regions ) ) {
			
			$region = $this->toArray( $region );	
				
			foreach ($region as $region_name) {
				
				foreach ($saved_regions as $key => $saved_region) {
				
					if ( strtolower( $region_name ) == strtolower( $saved_region['name'] ) ) {
					
						$country = array_merge( (array)$country, (array)$saved_region['countries']);
					
					}
				}
			}

		}	
		// append exlcluded regions to excluded countries		
		if (!empty( $exclude_region ) && ! empty( $saved_regions ) ) {

			$exclude_region = $this->toArray( $exclude_region );
			
			foreach ($exclude_region as $region_name ) {

				foreach ($saved_regions as $key => $saved_region) {
				
					if ( strtolower( $region_name ) == strtolower( $saved_region['name'] ) ) {

						$exclude_country = array_merge((array)$exclude_country, (array)$saved_region['countries']);

					}
				}	
			}
		}	
			
		//set target to false	
		$target = false;
			
		$user_country = $this->userCountry;
		if ( count( $country ) > 0 ) {

			foreach ( $country as $c ) {

				if ( strtolower( $user_country->name ) == strtolower( $c )|| strtolower( $user_country->isoCode ) == strtolower( $c ) ) {
					$target = true;
				}

			}
		} else {
			// If we don't have countries to target return true
			$target = true;

		}
		
		if ( count( $exclude_country ) > 0 ) {

			foreach ( $exclude_country as $c ) {

				if ( strtolower( $user_country->name ) == strtolower( $c ) || strtolower( $user_country->isoCode ) == strtolower( $c ) ) {
					$target = false;
				}

			}
		}	
		

		return $target;
	}

	/**
	 * Helper function to conver to array
	 * @param  string $value comma separated countries, etc
	 * @return array  
	 */
	private function toArray( $value = "" )
	{
		if ( empty( $value ) )
			return array();
		
		if ( is_array( $value ) )
			return $value;
	
		if ( stripos($value, ',') > 0)
			return explode( ',',$value );
	
		return array( $value );
	}


	/**
	 * Retrieve the current User country
	 * @return array Country array object
	 */
	public function get_user_country()
	{
		if( empty( $this->userCountry ) ) {
			$this->userCountry = $this->calculateUserCountry();
		}
		return $this->userCountry;
	}

	/**
	 * Get user Country
	 * @return array     country array
	 */
	public function calculateUserCountry() {
		
		global $wpdb;

		$opts = apply_filters('geot/settings_page/opts', get_option( 'geot_settings' ) );
		// If user set cookie use instead
		if( !defined('GEOT_DEBUG') &&  ! empty( $_COOKIE['geot_country']) || ( defined( 'GEOT_CLOUDFLARE' ) && !empty($_SERVER["HTTP_CF_IPCOUNTRY"]) ) ) {

			$iso_code = empty( $_COOKIE['geot_country'] ) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : $_COOKIE['geot_country'];

			$country = $this->getCountryByIsoCode( $iso_code );

			return $country;
		}
		// if we have a session it means we already calculated country on session
		if( !defined('GEOT_DEBUG') && !empty($_SESSION['geot_country']) ) {
			return unserialize($_SESSION['geot_country']);
		}

		$country = $this->getCountryByIp();

		return $country;

	}

	/**
	 * Get Country by ip
	 * @param  string $ip 
	 * @return array     country array
	 */
	public function getCountryByIp( $ip = "" ) {

		if( empty( $ip) ) {
			$ip = apply_filters( 'geot/user_ip', $_SERVER['REMOTE_ADDR']);		
		}
		try {
			$reader = new Reader(plugin_dir_path( dirname( __FILE__ ) ) . 'includes/data/GeoLite2-Country.mmdb');
			$country= $reader->country($ip)->country;
		} catch( GeoIp2\Exception\AddressNotFoundException $e ) {

			return array(
				'country' => $this->getCountryByIsoCode( apply_filters('geot/fallback_iso_code', 'US') ),
				'city'    => '',
				'zip'     => '',
				'state'   => '',
			);

			return false;
		}


		$_SESSION['geot_country'] = serialize($country);

		return $country;

	}

	/**
	 * Get country from database and return object like maxmind
	 * @param $iso_code
	 *
	 * @return StdClass
	 */
	private function getCountryByIsoCode( $iso_code ) {
		global $wpdb;
		$query 	 = "SELECT * FROM {$wpdb->base_prefix}geot_countries WHERE iso_code = %s";
		$result = $wpdb->get_row( $wpdb->prepare($query, array( $iso_code )), ARRAY_A );
		$country = new StdClass;

		$country->name      = $result['country'];
		$country->isoCode   = $result['iso_code'];

		return $country;
	}
}	

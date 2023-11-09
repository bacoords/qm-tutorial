<?php
/**
 * Custom tools page.
 *
 * @package QM_Tutorial
 */

namespace QM_Tutorial\Tools;

/**
 * Class QM_Tutorial_Tools
 */
class QM_Tutorial_Tools {


	/**
	 * QM_Tutorial_Tools constructor.
	 */
	public static function register() {
		add_action( 'init', array( get_class(), 'slow_admin_hook' ) );
		add_action( 'init', array( get_class(), 'slow_http_api_call' ) );
		add_action( 'init', array( get_class(), 'example_php_notice' ) );
	}



	/**
	 * Runs a slow query on every load.
	 */
	public static function slow_admin_hook() {

		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || wp_is_json_request() ) {
			return;
		}

		$query = new \WP_Query(
			array(
				'posts_per_page' => -1,
				'post__not_in'   => array( 1 ),
				'cache_results'  => false,
				'meta_query'     => array(
					array(
						'key'     => 'qm_tutorial_meta_int',
						'value'   => '0',
						'compare' => '>',
					),
					array(
						'key'     => 'qm_tutorial_meta_str',
						'compare' => 'EXISTS',
					),
				),
				'tax_query'      => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'slug',
						'terms'    => 'qm-tutorial',
					),
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => 'uncategorized',
						'operator' => 'NOT IN',
					),
				),
			)
		);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				update_post_meta( get_the_ID(), 'qm_tutorial_meta_counted', 1 );
			}
		}

		wp_reset_postdata();
	}



	/**
	 * Run a bad HTTP API call.
	 */
	public static function slow_http_api_call() {
		wp_remote_get( 'https://httpbin.org/delay/8' );
	}




	/**
	 * A custom function that throws a PHP error.
	 */
	public static function example_php_notice() {
		$foo = $bar;
	}
}

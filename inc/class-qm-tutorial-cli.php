<?php
/**
 * Custom command for WP-CLI
 *
 * @package QM_Tutorial
 */

namespace QM_Tutorial\CLI;

/**
 * Class QM_Tutorial_CLI
 */
class QM_Tutorial_CLI {

	/**
	 * QM_Tutorial_CLI constructor.
	 */
	public static function register() {
		if ( class_exists( '\WP_CLI' ) ) {
			\WP_CLI::add_command( 'qm-tutorial import', array( get_class(), 'qm_tutorial_import' ) );
		}
	}

	/**
	 * A custom command for WP-CLI
	 *
	 * ## OPTIONS
	 *
	 * [--limit=<number>]
	 * : The number of posts to import. Default: 100
	 *
	 * ## EXAMPLES
	 *
	 *     # Import data
	 *     $ wp qm-tutorial import
	 *
	 * @param array $args The arguments passed to the command.
	 * @param array $assoc_args The associative arguments passed to the command.
	 */
	public static function qm_tutorial_import( $args, $assoc_args ) {

		// Set default arguments.
		$assoc_args = wp_parse_args(
			$assoc_args,
			array(
				'limit' => 100,
			)
		);

		\WP_CLI::log( 'Importing ' . $assoc_args['limit'] . _n( ' post...', ' posts...', $assoc_args['limit'] ) );

		foreach ( range( 1, $assoc_args['limit'] ) as $i ) {
			wp_insert_post(
				array(
					'post_title'   => "Post {$i}",
					'post_content' => "This is post {$i}.",
					'post_status'  => 'publish',
					'post_type'    => 'post',
					'meta_input'   => array(
						'qm_tutorial_meta_str' => "This is meta for post {$i}.",
						'qm_tutorial_meta_int' => $i,
					),
					'tags_input'   => array( 'qm-tutorial', 'qm-tutorial-' . $i, 'qm-tutorial-group-' . (int) ( $i / 10 ) ),
				)
			);
			\WP_CLI::log( "Imported {$i}." );
		}
	}
}

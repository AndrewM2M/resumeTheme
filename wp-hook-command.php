<?php
/**
 * List callbacks registered to a given action or filter.
 *
 * <hook>
 * : The key for the action or filter.
 *
 * [--format=<format>]
 * : List callbacks as a table, JSON, or CSV. Default: table.
 *
 * EXAMPLES
 *
 *     wp --require=wp-hook-command.php hook wp_enqueue_script
 */
$hook_command = function( $args, $assoc_args ) {
	global $wp_filter;

	$assoc_args = array_merge( array(
		'format'        => 'table',
		), $assoc_args );

	$hook = $args[0];
	if ( ! isset( $wp_filter[ $hook ] ) ) {
		WP_CLI::error( "No callbacks specified for {$hook}." );
	}

	$callbacks_output = array();
	foreach( $wp_filter[ $hook ] as $priority => $callbacks ) {
		foreach( $callbacks as $callback ) {
			if ( is_array( $callback['function'] ) && is_object( $callback['function'][0] ) ) {
				$callback['function'] = get_class( $callback['function'][0] ) . '->' . $callback['function'][1];
			}
			$callbacks_output[] = array(
				'function'        => $callback['function'],
				'priority'        => $priority,
				'accepted_args'   => $callback['accepted_args'],
				);
		}
	}
	WP_CLI\Utils\format_items( $assoc_args['format'], $callbacks_output, array( 'function', 'priority', 'accepted_args' ) );
};
WP_CLI::add_command( 'hook', $hook_command );
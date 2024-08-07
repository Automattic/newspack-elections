<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

class Blocks {

	private array $blocks = [];

	public function __construct() {
	}

	public function hooks() {
		add_action( 'init', [ $this, 'provide_register_blocks_hook' ], 99 );
		add_action( 'gp_register_blocks', [ $this, 'register_blocks' ] );
	}

	public function provide_register_blocks_hook() {
		do_action( 'gp_register_blocks' );
	}

	public function is_late_block_registration() {
		// did_action returns the number of times ran, anything more than 0 should be true
		return ( did_action( 'gp_register_blocks' ) > 0 );
	}

	public function register( Abstracts\Block $block ) {
		$this->blocks[ $block->block_name ] = $block;

		if ( $this->is_late_block_registration() ) {
			$this->handle_block_registration( $block );
		}
	}

	public function register_blocks() {
		foreach ( $this->blocks as $name => $block ) {
			$this->handle_block_registration( $block );
		}
	}

	public function handle_block_registration( Abstracts\Block $block ) {
		$block->hooks();
		$block->register();
	}
}

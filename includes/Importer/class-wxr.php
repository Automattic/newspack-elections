<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

use Exception, XMLReader, DOMNode;
use Newspack\Govpack\Govpack;
/**
 * Register and handle the "USIO" Importer
 */
class WXR extends \Newspack\Govpack\Importer\Abstracts\Abstract_Importer {


	/**
	 * Creates and returns the XML reader for the Import File
	 *
	 * @param string $file  path of the JSON file.
	 * @throws Exception Could Not Open File to Parse.
	 */
	public static function create_reader( $file ) {

		$reader = new XMLReader();
		$status = $reader->open( $file );

		if ( ! $status ) {
			throw new Exception( 'Could Not Open File to Parse' );
		}

		return $reader;
	}

	/**
	 * Parses a term found in WXR
	 *
	 * @param XMLReader $reader  path of the JSON file.
	 * @param string $type  Type of node being processed.
	 */
	public static function read_term( $reader, $type ) {
		$node   = $reader->expand();
		$parsed = self::parse_term_node( $node, $type );
		if ( is_wp_error( $parsed ) ) {
			$reader->next();
			return false;
		}
		\as_enqueue_async_action( 'govpack_import_' . $type, $parsed, 'govpack' );
		$reader->next();
	}

	/**
	 * Parses a post/entity found in WXR
	 *
	 * @param XMLReader $reader  path of the JSON file.
	 * @param string $type  Type of node being processed.
	 */
	public static function read_item( $reader, $type ) {
		$node   = $reader->expand();
		$parsed = self::parse_post_node( $node, $type );
		if ( is_wp_error( $parsed ) ) {
			$reader->next();
			return false;
		}
		\as_enqueue_async_action( 'govpack_import_' . $type, $parsed, 'govpack' );
		$reader->next();
	}

	/**
	 * Process Loop over WML file
	 * calls  read_x functions for elements it finds
	 *
	 * @param XMLReader $reader  path of the JSON file.
	 */
	public static function process( $reader ) {

		while ( $reader->read() ) {
			// Only deal with element opens.
			if ( \XMLReader::ELEMENT !== $reader->nodeType ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			switch ( $reader->name ) {
				
				case 'wp:category':
					self::read_term( $reader, 'category' );
					break;
					
					
				case 'wp:tag':
					self::read_term( $reader, 'tag' );
					break;
					
				case 'wp:term':
					self::read_term( $reader, 'term' );
					break;

				case 'item':
					self::read_item( $reader, 'post' ); 
					break;
					
				default:
					// Skip this node, probably handled by something already.
					break;

			}       
		}
	}

	/**
	 * Parse a Term found in the WXR
	 * See https://github.com/humanmade/WordPress-Importer/blob/master/class-wxr-importer.php#L1581
	 * 
	 * @param DOMNode $node  path of the JSON file.
	 * @param string $type  type being processed.
	 */
	protected static function parse_term_node( $node, $type = 'term' ) {
		$data = [];
		$meta = [];

		$tag_name = [
			'id'          => 'wp:term_id',
			'taxonomy'    => 'wp:term_taxonomy',
			'slug'        => 'wp:term_slug',
			'parent'      => 'wp:term_parent',
			'name'        => 'wp:term_name',
			'description' => 'wp:term_description',
		];
	

		// Special casing!
		switch ( $type ) {
			case 'category':
				$tag_name['slug']        = 'wp:category_nicename';
				$tag_name['parent']      = 'wp:category_parent';
				$tag_name['name']        = 'wp:cat_name';
				$tag_name['description'] = 'wp:category_description';
				$tag_name['taxonomy']    = null;

				$data['taxonomy'] = 'category';
				break;

			case 'tag':
				$tag_name['slug']        = 'wp:tag_slug';
				$tag_name['parent']      = null;
				$tag_name['name']        = 'wp:tag_name';
				$tag_name['description'] = 'wp:tag_description';
				$tag_name['taxonomy']    = null;

				$data['taxonomy'] = 'post_tag';
				break;
		}

		foreach ( $node->childNodes as $child ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			// We only care about child elements.
			if ( XML_ELEMENT_NODE !== $child->nodeType ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			$key = array_search( $child->tagName, $tag_name, true );//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			if ( $key ) {
				$data[ $key ] = $child->textContent; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			}
		}

		if ( empty( $data['taxonomy'] ) ) {
			return null;
		}

		// Compatibility with WXR 1.0.
		if ( 'tag' === $data['taxonomy'] ) {
			$data['taxonomy'] = 'post_tag';
		}

		return compact( 'data', 'meta' );
	}

	/**
	 * Parse a Post found in the WXR
	 * See https://github.com/humanmade/WordPress-Importer/blob/master/class-wxr-importer.php#L597
	 *
	 * @param DOMNode $node XML node being processed.
	 */
	protected static function parse_post_node( $node ) {
		$data     = [];
		$meta     = [];
		$comments = [];
		$terms    = [];

		foreach ( $node->childNodes as $child ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			// We only care about child elements.
			if ( XML_ELEMENT_NODE !== $child->nodeType ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			switch ( $child->tagName ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				case 'wp:post_type':
					$data['post_type'] = $child->textContent; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'title':
					$data['post_title'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'guid':
					$data['guid'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'dc:creator':
					$data['post_author'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'content:encoded':
					$data['post_content'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'excerpt:encoded':
					$data['post_excerpt'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:post_id':
					$data['post_id'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:post_date':
					$data['post_date'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:post_date_gmt':
					$data['post_date_gmt'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:comment_status':
					$data['comment_status'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:ping_status':
					$data['ping_status'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:post_name':
					$data['post_name'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:status':
					$data['post_status'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

					if ( 'auto-draft' === $data['post_status'] ) {
						// Bail now.
						return new \WP_Error(
							'wxr_importer.post.cannot_import_draft',
							__( 'Cannot import auto-draft posts' ),
							$data
						);
					}
					break;

				case 'wp:post_parent':
					$data['post_parent'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:menu_order':
					$data['menu_order'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:post_password':
					$data['post_password'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:is_sticky':
					$data['is_sticky'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:attachment_url':
					$data['attachment_url'] = $child->textContent;//phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:postmeta':
					$meta_item = self::parse_meta_node( $child );
					if ( ! empty( $meta_item ) ) {
						$meta[] = $meta_item;
					}
					break;


				case 'category':
					$term_item = self::parse_term_node( $child, 'category' );
					if ( ! empty( $term_item ) ) {
						$terms[] = $term_item;
					}
					break;
			}
		}

		return compact( 'data', 'meta', 'comments', 'terms' );
	}

	/**
	 * Parse a Meta Item found in the WXR
	 * See https://github.com/humanmade/WordPress-Importer/blob/master/class-wxr-importer.php#L1101
	 *
	 * @param DOMNode $node XML node being processed.
	 */
	protected static function parse_meta_node( $node ) {
		foreach ( $node->childNodes as $child ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			// We only care about child elements.
			if ( XML_ELEMENT_NODE !== $child->nodeType ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			switch ( $child->tagName ) { //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				case 'wp:meta_key':
					$key = $child->textContent; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;

				case 'wp:meta_value':
					$value = $child->textContent; //phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					break;
			}
		}

		if ( empty( $key ) || empty( $value ) ) {
			return null;
		}

		return compact( 'key', 'value' );
	}
}
<?php
/**
 * Govpack profile template.
 *
 * @package Newspack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
?>
<aside>
<h3><?php echo esc_html( $profile_data['first_name'] . ' ' . $profile_data['last_name'] ); ?></h3>
<p><?php echo esc_html( $profile_data['party'] ); ?> — <?php echo esc_html( $profile_data['state'] ); ?></p>
<p><?php echo esc_html( $profile_data['title'] ); ?>, <?php echo esc_html( $profile_data['legislative_body'] ); ?></p>

<p><a href="<?php echo esc_url( 'tel:' . $profile_data['phone'] ); ?>">call</a></p>
<p><a href="<?php echo esc_url( 'mailto:' . $profile_data['email'] ); ?>">email</a></p>
<p><a href="<?php echo esc_url( $profile_data['website'] ); ?>">website</a></p>
<p><a href="<?php echo esc_url( $profile_data['facebook'] ); ?>">facebook</a></p>

<?php echo wp_kses_post( get_the_post_thumbnail( $profile_data['id'] ) ); ?>

</aside>

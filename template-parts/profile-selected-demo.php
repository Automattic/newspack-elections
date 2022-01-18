<?php
/**
 * Govpack profile template.
 *
 * @package Newspack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
?>
<aside style="padding: 2rem; background-color:rgba(0,0,0,0.1);" >

    <h2>Selected Demo Block</h2>
    <dl>
        <dt>Prefix</dt>
        <dd><?php echo esc_html( $profile_data['prefix'] ?? "-" ); ?></dd>

        <dt>First Name</dt>
        <dd><?php echo esc_html( $profile_data['first_name'] ); ?></dd>

        <dt>Last Name</dt>
        <dd><?php echo esc_html( $profile_data['last_name'] ); ?></dd>
    </dl>
</aside>

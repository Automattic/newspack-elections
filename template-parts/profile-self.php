<?php
/**
 * Govpack profile template.
 *
 * @package Newspack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$classes = join( ' ', array_filter( [ 
    'wp-block-govpack-profile-self', 
    $attributes['className'],
    (isset($attributes['align']) ? "align" . $attributes['align'] : false )
] ) );

$availableWidths = [
    "small" => [
        "label" => "Small",
        "value" => "small",
        "maxWidth" => "300px"
    ],
    "medium" =>[
        "label" => "Medium",
        "value" => "medium",
        "maxWidth" => "400px"
    ],
    "large" =>[
        "label" => "Large",
        "value" => "large",
        "maxWidth" => "600px"
    ],
    "full" => [
        "label" => "Full",
        "value" => "full",
        "maxWidth" => "100%"
    ]
    ];


$styles = join(" ", [
    "max-width:" . $availableWidths[$attributes['width'] ?? "full"]["maxWidth"] . ";"
]);

$container_classes = join( ' ', array_filter( [ 
    'wp-block-govpack-profile-self__container', 
    (isset($attributes['avatarAlignment']) && ($attributes['avatarAlignment'] === "right" ? "wp-block-govpack-profile-self__container--right" : false)),
    (isset($attributes['avatarAlignment']) && ($attributes['avatarAlignment'] === "left" ? "wp-block-govpack-profile-self__container--left" : false)),
    (isset($attributes['align']) && ($attributes['align'] === "center" ? "wp-block-govpack-profile-self__container--align-center" : false)),
    ($attributes['className'] === "is-styled-center" ? "wp-block-govpack-profile-self__container--center" : false)
] ) );


?>

<aside class="<?php echo esc_attr( $classes );?>" style="<?php echo esc_attr($styles );?>">
    <div class="<?php echo esc_attr( $container_classes ); ?>">
	   

        <div class="wp-block-govpack-profile-self__avatar">
            <figure>
                <?php echo GP_Maybe_Link(wp_kses_post( get_the_post_thumbnail( $profile_data['id']) ), $profile_data['link'], false); ?>
            </figure>
		</div>


            <div class="wp-block-govpack-profile-self__info">
                
                <?php
                    Row($profile_data['legislative_body'], $attributes['showLegislativeBody']);
                    Row($profile_data['position'] ?? null, $attributes['showPosition']);
                    Row($profile_data['party'] , $attributes['showParty']);
                    Row($profile_data['state'], $attributes['showState']);
                    Row(GP_Contacts($profile_data,  $attributes), ($attributes['showEmail'] ||  $attributes['showSocial'] && $profile_data['hasSocial']) );
                    Row($profile_data['address'], $attributes['showAddress']);
                    
                ?>
            </div>
        

    </div> <!-- end __container -->
</aside>

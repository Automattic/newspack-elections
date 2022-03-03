<?php
/**
 * Govpack profile template.
 *
 * @package Newspack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$classes = join( ' ', array_filter( [ 
    'wp-block-govpack-profile', 
    $attributes['className'],
    ($attributes['align'] ? "align" . $attributes['align'] : false )
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
    "max-width:" . $availableWidths[$attributes['width']]["maxWidth"] . ";"
]);

$container_classes = join( ' ', array_filter( [ 
    'wp-block-govpack-profile__container', 
    ($attributes['avatarAlignment'] === "right" ? "wp-block-govpack-profile__container--right" : false),
    ($attributes['avatarAlignment'] === "left" ? "wp-block-govpack-profile__container--left" : false),
    ($attributes['align'] === "center" ? "wp-block-govpack-profile__container--align-center" : false),
    ($attributes['className'] === "is-styled-center" ? "wp-block-govpack-profile__container--center" : false)
] ) );


function Row($value, $display) {

    if(!$display){
        return null;
    }

    if(!$value){
        return null;
    }

    echo "<div class=\"wp-block-govpack-profile__line\">". $value ."</div>";

}

function GP_Link($url, $title){
    return "<a href=" . $url . ">More About ".  $title . "</a>";
}

function GP_Maybe_Link($content, $url, $useLink){

    if(!$useLink){
        return $content;
    }
    return "<a href=" . $url . ">" . $content . "</a>";
}

function GP_Contacts($profile_data, $attributes){

    $li =   "<li><a href=\"%s\">%s</a></li>";

    if($attributes["showEmail"] && $profile_data["email"]){
        $email = sprintf($li, "mailto:" . $profile_data["email"], "em");
    }

  
    $social = "";
    if($attributes["showSocial"]){

        if(isset($profile_data["facebook"]) && $profile_data["facebook"]){
            $social .= sprintf($li, $profile_data["facebook"], "fb");
        }

        if(isset($profile_data["twitter"]) && $profile_data["twitter"]){
            $social .= sprintf($li, $profile_data["twitter"], "tw");
        }

        if(isset($profile_data["linkedin"]) && $profile_data["linkedin"]){
            $social .= sprintf($li, $profile_data["linkedin"], "li");
        }

        if(isset($profile_data["instagram"]) && $profile_data["instagram"]){
            $social .= sprintf($li, $profile_data["instagram"], "in");
        }

    }
  

    return sprintf("<div class=\"wp-block-govpack-profile__contacts\">
                <ul>
                    %s
                    %s
                </ul>
            </div>",
        $email ?? '',
        $social ?? '',
    );
}

?>

<aside class="<?php echo esc_attr( $classes );?>" style="<?php echo esc_attr($styles );?>">
    <div class="<?php echo esc_attr( $container_classes ); ?>">
	   

        <div class="wp-block-govpack-profile__avatar">
            <figure
                style = "
                    border-radius: <?php echo $attributes['avatarBorderRadius']?>;
                    height:<?php echo $attributes['avatarSize']?>px;
                    width: <?php echo $attributes['avatarSize']?>px;
                "
            >
                <?php echo GP_Maybe_Link(wp_kses_post( get_the_post_thumbnail( $profile_data['id']) ), $profile_data['link'], $attributes["showProfileLink"]); ?>
            </figure>
		</div>


            <div class="wp-block-govpack-profile__info">
                <div class="wp-block-govpack-profile__line">
                    <h3> <?php echo GP_Maybe_Link($profile_data['name'], $profile_data['link'], $attributes["showProfileLink"]); ?></h3>

                    <?php if($attributes["showBio"] && $profile_data['bio'] ) {
                        echo $profile_data['bio'];
                    } ?>
                      <?php if($attributes["showProfileLink"]) {?>
                        <p><?php echo GP_Link($profile_data['link'], $profile_data['name']);?></p>
                    <?php } ?>
                </div>
                <?php
                    Row($profile_data['legislative_body'], $attributes['showLegislativeBody']);
                    Row($profile_data['position'] ?? null, $attributes['showPosition']);
                    Row($profile_data['party'] , $attributes['showParty']);
                    Row($profile_data['state'], $attributes['showState']);
                    //<Row value={<Contacts />} display={showEmail || (showSocial && profile.hasSocial)}/>
                    Row(GP_Contacts($profile_data,  $attributes), ($attributes['showEmail'] ||  $attributes['showSocial'] && $profile_data['hasSocial']) );

                    Row($profile_data['address'], $attributes['showAddress']);
                    Row(GP_Link($profile_data['link'], $profile_data['name']), $attributes['showProfileLink']);
                    
                ?>
            </div>
        

    </div> <!-- end __container -->
</aside>

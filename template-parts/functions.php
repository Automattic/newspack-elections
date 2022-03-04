<?php

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
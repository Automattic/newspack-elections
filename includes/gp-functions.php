<?php

use Govpack\Core\Permalinks;

function gp_get_permalink_structure(){
	return Permalinks::instance()->permalinks();
}

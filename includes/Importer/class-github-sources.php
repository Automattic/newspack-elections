<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;



/**
 * Register and handle the "USIO" Importer
 */
class GitHub_Sources {

    const states = [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District of Columbia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming',
    ];

    /**
	 * get URLS for Github files
	 */
    public static function urls(){

        $data = [
            "all" => [
                "label" => "All",
                "items" => [
                    "collected" => [
                        "label" => "Al data"
                    ],
                ]
            ],
            "us-federal" => [
                "label" => "Federal",
                "items" => [
                    "us-house" => [
                        "label" => "US House"
                    ],
                    "us-senate"  => [
                        "label" => "US Senate"
                    ]
                ]
            ],
            "us-states" => [
                "label" => "States",
                "items" => []
            ],
        ];

       foreach(self::states as $abbr => $label){
           $data["us-states"]["items"][strtolower($abbr)] = [
               "label" => $label
           ];
       }

        foreach($data as $group => $items){
            foreach($items as $item => $info){
                $data[$group]["items"][$item]["key"] = sprintf("%s----%s", $group, $item);
                $data[$group]["items"][$item]["url"] = sprintf("https://github.com/govpack-wp/data/raw/main/%s/%s.xml", $group, $item);
            }
        }

        return $data;
    }
}


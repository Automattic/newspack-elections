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
                        "label" => "All data"
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
       

        foreach($data as $group_key => $group){
            foreach($group["items"] as $item => $info){
                $data[$group_key]["items"][$item]["key"] = sprintf("%s----%s", $group_key, $item);
                $data[$group_key]["items"][$item]["url"] = sprintf("https://github.com/govpack-wp/data/raw/main/%s/%s.xml", $group_key, $item);
            }
        }
        

        return $data;
    }

    public static function flattened_urls(){
        $source = self::urls(); 
        $urls = [];
        foreach($source as $key => $value){
            $urls = array_merge($urls, $value["items"]);
        }
        return $urls;
    }

    public static function get_source_from_key($key){
        $sources = self::flattened_urls();
        $source = array_filter($sources, function($val) use ($key) {
            return ($val["key"] === $key);
        });

        if(!$source){
            throw new \Exception("No Source Found");
        }
        return reset($source);
    }

    public static function extra_upload_mimes($mime_types){
        $mime_types['xml'] = 'text/xml'; //Adding svg extension
        return $mime_types;
    }

   
    public static function sideload($source){
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $temp_file = download_url( $source['url'], 5);

        if (is_wp_error( $temp_file ) ) {
            throw new \Exception("Could Not Download File");
        }


        $file = array(
            'name'     => basename($source['url']), 
            'tmp_name' => $temp_file,
            'error'    => 0,
            'size'     => filesize($temp_file),
        );
    
        $overrides = array(
            // Tells WordPress to not look for the POST form
            // fields that would normally be present as
            // we downloaded the file from a remote server, so there
            // will be no form fields
            // Default is true
            'test_form' => false,
    
            // Setting this to false lets WordPress allow empty files, not recommended
            // Default is true
            'test_size' => true,
        );

        add_filter( 'upload_dir', [__class__, "change_upload_dir"] );
        add_filter( 'upload_mimes', [__class__, 'extra_upload_mimes'], 1, 1);

        // Move the temporary file into the uploads directory
	    $results = wp_handle_sideload( $file, $overrides );

        remove_filter( 'upload_dir', [__class__, "change_upload_dir"] );
        remove_filter( 'upload_mimes', [__class__, 'extra_upload_mimes'], 1, 1);

        return $results;
    }

    public static function change_upload_dir( $dir ) {
        return array(
            'path'   => $dir['basedir'] . '/govpack',
            'url'    => $dir['baseurl'] . '/govpack',
            'subdir' => '/govpack',
        ) + $dir;
    }

    public static function download(\WP_REST_Request $request){

        if(!$request->has_param("source_file")){
            return new \WP_Error("NO SOURCE FILE SET");
        }

        try{

            $source = self::get_source_from_key($request->get_param("source_file"));
            $temp_file = self::sideload($source);
            \update_option("govpack_import_path", $temp_file["file"]);

            return  [
                "status" => "done"
            ];

        } catch (\Exception $e){
            return new \WP_Error($e->getMessage());
        }
    }
}


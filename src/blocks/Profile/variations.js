import {justifyLeft, layout, mediaAndText} from "@wordpress/icons"

import { DEFAULT_TEMPLATE, FULL_TEMPLATE, HORIZONTAL_TEMPLATE } from "./edit/default-template"


const defaultProfile = {
	'name' : "profile-default",
	'title' : "Profile",
	'description' : "Profile",
	isDefault : true,
	icon : layout,
	isActive: [ 'variation', 'className' ],
	attributes : {
		"variation" : false
	},
}

const miniProfile = {
	'name' : "profile-mini",
	'title' : "Mini Profile",
	isDefault : false,
	isActive: [ 'variation', 'className' ],
	icon : justifyLeft,
	example : {
		attributes : {
			"variation": "mini",
			"preview" : true,
			"width" : "wide",
			"align": "none",
			"backgroundColor":"accent",
			"verticalAlignment":"center",
			"fontSize":"medium",
			"textColor":"base-2",
			"style":{
				"spacing":{
					"padding":{
						"top":"0.5rem","bottom":"0.5rem","left":"0.5rem","right":"0.5rem"}
				},
				"typography":{ "textAlign":"left" }
			},
			"layout":{
				"type":"flex",
				"verticalAlignment":"middle",
				"justifyContent":"left",
				"flexWrap":"nowrap"
			},
		},
		innerBlocks : [
			{
				name : "core/post-featured-image", 
				attributes :{"style":{"layout":{"selfStretch":"fixed","flexSize":"130px"},"border":{"radius":"100px"}}}
			},
			{
				name : "core/group", 
				attributes : {"style":{"spacing":{"blockGap":"0.2rem"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"constrained"}} , 
				innerBlocks: [
					{
						name : "npe/profile-name", 
						attributes : {"style":{"typography":{"fontStyle":"normal","fontWeight":"1000","fontSize":"1.4rem"},"spacing":{"padding":{"bottom":"0.5rem"}}}}, 
						innerBlocks : []
					},
					{
						name :"npe/profile-row", 
						attributes :{
							"field": {
								"key": "legislative_body", 
								"type":"taxonomy"
							},
							"fontSize":"small"
						}, 
						innerBlocks : []
					},
					{
						name :"npe/profile-row", 
						attributes :{
							"field": {
								"key": "party",
								"type":"taxonomy"
							},
							"fontSize":"small"
						}, 
						innerBlocks :[]
					},
					{
						name :"npe/profile-row", 
						attributes :{
							"field": {
								"key": "officeholder_status",
								"type":"taxonomy"
							},
							"fontSize":"small"
						}, 
						innerBlocks :[]
					}
				]
			}
		]
	},
	attributes : {
		"variation": "mini",
		"width" : "wide",
		"align": "none",
		
		"verticalAlignment":"center",
		"fontSize":"small",
		
		"style":{
			"spacing":{
				"padding":{
					"top":"0.5rem","bottom":"0.5rem","left":"0.5rem","right":"0.5rem"}
			},
			"typography":{"textAlign":"left"},
			
		},
		"layout":{
			"type":"flex",
			"verticalAlignment":"middle",
			"justifyContent":"left",
			"flexWrap":"nowrap"
		},
		
	},
	innerBlocks : [
		[
			"core/post-featured-image", 
			{"style":{"layout":{"selfStretch":"fixed","flexSize":"130px"},"border":{"radius":"100px"}}}
		],
		[
			"npe/profile-row-group",
			{"style":{"spacing":{"blockGap":"0.2rem"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"constrained"}} , 
			[
				["npe/profile-name", {"style":{"typography":{"fontStyle":"normal","fontWeight":"1000","fontSize":"1.4rem"},"spacing":{"padding":{"bottom":"0.5rem"}}}}, []],
				["npe/profile-row", { 
					"field":{
						"type":"taxonomy",
						"key":"legislative_body",
					},
					"fontSize":"small" 
				}, []],
				["npe/profile-row", { 
					"field":{
						"type":"taxonomy",
						"key":"party"
					},
					"fontSize":"small"
				}, []],
				["npe/profile-row", { 
					"field":{
						"type":"taxonomy",
						"key":"status"
					},
					"fontSize":"small"
				}, []]
			]
		]
	]
}



const fullProfile = {
	'name' : "profile-full",
	'title' : "Full Profile",
	'description' : "Profile",
	isDefault : false,
	icon : layout,
	isActive: [ 'variation', 'className' ],
	attributes : {
		"variation" : "full",
		"style":{"spacing":{"blockGap":"0"}}
	},
	"innerBlocks": FULL_TEMPLATE
}

export const variations = [
	defaultProfile,
	fullProfile,
	{
		'name' : "gp-profile-full-inline",
		'title' : "Inline Profile",
		isDefault : false,
		icon : mediaAndText,
		attributes : {
			
			align: "left",
			"style": {
				"spacing":{
					"blockGap":"0"
				},
			},
			"layout":{ 
				"type":"flex",
				"orientation":"vertical",
				"justifyContent":"stretch"
			}
		},
		"innerBlocks" : [
			[
				"core/post-featured-image", 
				{"isLink":true,"aspectRatio":"2/3","style":{"layout":{"selfStretch":"fit","flexSize":null},"border":{"radius":"0px"}}}
			],
			[
				
				"npe/profile-row-group",
				{
					"separatorStyles":{"height":"1px","spacing":{"margin":{"top":"0","bottom":"0"}}},
					"style":{"layout":{"selfStretch":"fill","flexSize":null},
					"spacing":{
						"blockGap":"7px",
						"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}
					}}
				},
				[ 	
					[
						"npe/profile-name",
						{"isLink":true},
						[]
					],
					[
						"npe/profile-row", {
							"field":{
								"key" : "legislative_body",
								"type":"taxonomy"
							}
						}
					],
					[
						"npe/profile-separator"
					],
					[
						"npe/profile-row",  {
							"field":{
								"key" : "party",
								"type":"taxonomy"
							}
						}
					],
					[
						"npe/profile-separator", {}
					],
					[	
						"npe/profile-row", {
							"field":{
								"key" : "endorsements",
								"type":"text"
							},
						},
					],
					[
						"npe/profile-bio",
						{"moreText":" ","showMoreOnNewLine":false,"excerptLength":27},
						[]
					]
				]
			]
		]
			
	},
	miniProfile,
	{
		name : "horizontal-profile",
		title : "Horizontal Profile",
		isDefault : false,
		icon : justifyLeft,
		attributes : {
			align : "wide",
			"verticalAlignment" : "stretch",
			layout: {
				type: "flex",
				orientation: "horizontal",
				justifyContent: "left"
			}
		},
		innerBlocks : HORIZONTAL_TEMPLATE
	}
]
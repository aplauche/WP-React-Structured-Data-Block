<?php 

function fsdhh_happy_hour_post_type(){
  $labels = array(
		'name'                  => _x( 'Happy Hours', 'Post type general name', 'fsd-hh' ),
		'singular_name'         => _x( 'Happy Hour', 'Post type singular name', 'fsd-hh' ),
		'menu_name'             => _x( 'Happy Hours', 'Admin Menu text', 'fsd-hh' ),
		'name_admin_bar'        => _x( 'Happy Hour', 'Add New on Toolbar', 'fsd-hh' ),
		'add_new'               => __( 'Add New', 'fsd-hh' ),
		'add_new_item'          => __( 'Add New Happy Hour', 'fsd-hh' ),
		'new_item'              => __( 'New Happy Hour', 'fsd-hh' ),
		'edit_item'             => __( 'Edit Happy Hour', 'fsd-hh' ),
		'view_item'             => __( 'View Happy Hour', 'fsd-hh' ),
		'all_items'             => __( 'All Happy Hours', 'fsd-hh' ),
		'search_items'          => __( 'Search Happy Hours', 'fsd-hh' ),
		'parent_item_colon'     => __( 'Parent Happy Hours:', 'fsd-hh' ),
		'not_found'             => __( 'No happy hours found.', 'fsd-hh' ),
		'not_found_in_trash'    => __( 'No happy hours found in Trash.', 'fsd-hh' ),
		'featured_image'        => _x( 'Happy Hour Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'fsd-hh' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'fsd-hh' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'fsd-hh' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'fsd-hh' ),
		'archives'              => _x( 'Happy Hour archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'fsd-hh' ),
		'insert_into_item'      => _x( 'Insert into happy hour', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'fsd-hh' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this happy hour', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'fsd-hh' ),
		'filter_items_list'     => _x( 'Filter happy hours list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'fsd-hh' ),
		'items_list_navigation' => _x( 'Happy Hours list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'fsd-hh' ),
		'items_list'            => _x( 'Happy Hours list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'fsd-hh' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true, // enables gutenberg and custom rest endpoint
		'query_var'          => true, // ?recipe=pizza  - you can also set to custom string
		'rewrite'            => array( 'slug' => 'happyhour', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
    'description'        => __('A custom happy hour post type', 'fsd-hh'),
    'template' => array(
      array('fsdhh/happy-hour', array(
        'lock' => array(
          'move'   => true,
          'remove' => true,
        ),
      ))
    )
	);

	register_post_type( 'happyhour', $args );

  register_taxonomy( 'special', 'happyhour', [
    'label' => __('Special', 'fsd-hh'),
    'rewrite' => ['slug' => 'special'],
    'show_in_rest' => true
  ] );

  register_taxonomy( 'neighborhood', 'happyhour', [
    'label' => __('Neighborhood', 'fsd-hh'),
    'rewrite' => ['slug' => 'neighborhood'],
    'show_in_rest' => true
  ] );

	register_post_meta('happyhour', 'happy_hour_times', [
		'type' => 'object',
		'description' => 'Happy Hour Times',
		'single' => true,
    // 'default' => [
    //   'sunday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'monday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'tuesday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'wednesday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'thursday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'friday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    //   'saturday' => [
    //     ["start" => "", "end" => ""]
    //   ],
    // ],

		'show_in_rest' => [
        'schema' => [
          'type'       => 'object',
          'properties' => [
              'sunday' => [
                'type' => 'object',
                'properties' => [
                  'start' => ['type' => 'string'],
                  'end' => ['type' => 'string']
                ]
              ],
              'monday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
              'tuesday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
              'wednesday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
              'thursday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
              'friday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
              'saturday' => [
                  'type' => 'object',
                  'properties' => [
                    'start' => ['type' => 'string'],
                    'end' => ['type' => 'string']
                  ]
              ],
          ],
      ],
    ],
    //'sanitize_callback' => 'sanitize_text_field', // we can define a custom endpoint to validate
    'auth_callback' => function(){
			return current_user_can( 'edit_posts' );
		}
	]);
}
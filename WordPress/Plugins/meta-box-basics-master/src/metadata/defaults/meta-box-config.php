<?php
/**
 * MetaBox config
 *
 * @since       1.0.1
 * @author      Antal
 * @link        https://antaltettinger.com
 * @license     GNU-2.0+
 */


namespace AntalTettinger\Metadata;
return array(
    //This unique ID is used for storing in the config-store, adding metaboxes, saving and for the view file.
    'unique-meta-box-id' => array(
        'add_meta_box' => array(
            'title' => '',
            'screen' => '',
            'context' => 'advanced',
            'priority' => 'default',
            'callback_args' => null
        ),

        'custom_fields' => array(
            'meta_key' => array(
                // True - means it's a single
                // False - means it's an array
                'is_single'    => true,
                // Specify the custom field's default value.
                'default'      => '',
                // What is the state that signals to delete this meta key
                // from the database.
                'delete_state' => '',
                // callable sanitizer function such as
                // sanitize_text_field, sanitize_email, strip_tags, intval, etc.
                'sanitize'     => 'sanitize_text_field',
            )
            ),
        'view' => ''
    )
);
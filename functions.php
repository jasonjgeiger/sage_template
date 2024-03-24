<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


/*
|--------------------------------------------------------------------------
| Register Carbon Fields
|--------------------------------------------------------------------------
|
| Provides structured settings fields unique to this theme.
| A method support the easy maintainence of email addresses, service IDs, and keys.
|
*/
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {

    // Default options page
    $basic_options_container = Container::make( 'theme_options', __( 'Theme Settings' ) )
    ->add_fields( array(
        Field::make( 'separator', 'separator_placeholder', __( 'Sample section' ) ),
                Field::make( 'text', 'placeholder', 'Sample input' ),
    ) );


    Container::make( 'theme_options', __( 'Analytics' ) )
        ->set_page_parent( $basic_options_container ) 
        ->add_fields( array(
            Field::make( 'separator', 'separator_google', __( 'Google Analytics' ) ),
                Field::make( 'text', 'ga_id', 'Analytics ID' ),
                Field::make( 'text', 'gtm_id', 'Tag Manager ID' ),
                Field::make( 'text', 'gtag_id', 'Tag ID' ),
                Field::make( 'text', 'google_site_verification', 'Site Verification ID' )
        ) );
    
    Container::make( 'theme_options', __( 'Comms' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'separator', 'separator_sendgrid', __( 'Contact form settings' ) ),
                Field::make( 'text', 'sendgrid_to_email', 'Send To - Email Addresses (comma separated)' ),
                Field::make( 'text', 'sendgrid_to_test', 'Test - Email Addresses (comma separated)' ),
                Field::make( 'text', 'sendgrid_from_email', 'Send From - Email Address' ),
                Field::make( 'select', 'email_testing', __( 'Testing enabled' ) )
                    ->set_options( array(
                        'true' => 'Yes',
                        'false' => 'No',
                    ) )
        ) );

        Container::make( 'theme_options', __( 'API Keys & Hooks' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'separator', 'separator_recaptcha', 'Google Recaptcha v3' ),
                Field::make( 'text', 'recaptcha_client_key', 'Client Key' ),
                Field::make( 'text', 'recaptcha_secret_key', 'Secret Key' ),
            Field::make( 'separator', 'separator_sendgrid', __( 'SendGrid' ) ),
                Field::make( 'text', 'sendgrid_key', 'API Key' ),
            Field::make( 'separator', 'separator_make', __( 'Make.com' ) ),
                Field::make( 'text', 'makecom_webhook_url', __( 'Webhook URL' ) ),
            Field::make( 'separator', 'separator_mailchimp', __( 'MailChimp' ) ),
                Field::make( 'text', 'mailchimp_key', __( 'API key' ) ),
                Field::make( 'text', 'mailchimp_list_id', 'MailChimp List ID' ),
                Field::make( 'text', 'mailchimp_unsubscribe_url', 'MailChimp Unsubscribe URL' ),
        ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_page_fields' );
function crb_attach_page_fields() {
        Container::make( 'post_meta', __( 'Page Data' ) )
        ->where( 'post_type', '=', 'page' )
        ->add_fields( array( 
            Field::make( 'textarea', 'page_details', __( 'Include the full Page' ) ),
         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_post_fields' );
function crb_attach_post_fields() {
        Container::make( 'post_meta', __( 'Post Data' ) )
        ->where( 'post_type', '=', 'post' )
        ->add_fields( array( 
            Field::make( 'textarea', 'post_details', __( 'Include the full Post' ) ),
         ) );
}

add_action( 'carbon_fields_register_fields', 'crb_attach_testimonal_fields' );
function crb_attach_testimonal_fields() {
        Container::make( 'post_meta', __( 'Testimonial Data' ) )
        ->where( 'post_type', '=', 'testimonials' )
        ->add_fields( array( 
            Field::make( 'textarea', 'testimonal_details', __( 'Include the full testimonial' ) ),
         ) );

        Container::make( 'post_meta', __( 'Testimonial Additional' ) )
        ->where( 'post_type', '=', 'testimonials' )
        ->add_fields( array( 
            Field::make( 'text', 'testimonal_author', __( 'Author' ) ),
         ) );

}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
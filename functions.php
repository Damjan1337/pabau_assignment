<?php
function simple_lead_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'primary' => 'Primary Menu',
    ));
}
add_action('after_setup_theme', 'simple_lead_theme_setup');

function simple_lead_scripts()
{
    wp_enqueue_style('main-style', get_stylesheet_uri(), array(), '1.0.7');

    wp_enqueue_script('jquery');
    wp_enqueue_script('lead-form', get_template_directory_uri() . '/assets/js/lead-form.js', array('jquery'), '1.0.7', true);
    wp_localize_script('lead-form', 'lead_form_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'simple_lead_scripts');

function process_lead_form()
{
    // According to Pabau documentation: https://support.pabau.com/knowledge/create-lead-api
    $api_url = 'https://uk2.pabau.me/api/v1/lead/create';
    $api_key = 'MTUyMTc5c6555c14e129a73a29c7cfd29ecd593';

    $lead_data = array(
        'first_name' => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '',
        'last_name' => isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '',
        'email' => isset($_POST['email']) ? sanitize_email($_POST['email']) : '',
        'mobile' => isset($_POST['mobile']) ? sanitize_text_field($_POST['mobile']) : '',
        'lead_source' => 'Website'
    );

    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($lead_data),
        'timeout' => 45,
        'sslverify' => false
    );

    $response = wp_remote_post($api_url, $args);

    if (is_wp_error($response)) {
        echo json_encode(array(
            'success' => false,
            'message' => 'Error connecting to API: ' . $response->get_error_message()
        ));
    } else {
        $status_code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ($status_code >= 200 && $status_code < 300 && isset($body['id'])) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Thank you! Your information has been submitted successfully.'
            ));
        } else {
            $error_msg = 'Failed to create lead. Please try again.';
            if (isset($body['message'])) {
                $error_msg = $body['message'];
            } elseif (!empty($response_body)) {
                $error_msg = 'API Error: ' . substr(wp_remote_retrieve_body($response), 0, 100);
            }

            echo json_encode(array(
                'success' => false,
                'message' => $error_msg
            ));
        }
    }

    wp_die();
}
add_action('wp_ajax_process_lead_form', 'process_lead_form');
add_action('wp_ajax_nopriv_process_lead_form', 'process_lead_form');

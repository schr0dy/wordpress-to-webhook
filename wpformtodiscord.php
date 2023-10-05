<?php
/**
 * Plugin Name: WPForms Discord Integration
 * Description: Send WPForms entries to Discord webhook.
 * Version: 1.0
 * Author: vikarbonato
 */

add_action('wpforms_process_complete', 'send_wpforms_to_discord', 10, 4);

function send_wpforms_to_discord($fields, $entry, $form_data, $entry_id) {
    $webhook_url = 'YOUR WEBHOOK LINK HERE';
	$message = "||@here||\n";
    $message .= "*You got a new contact request:*\n";
	$field_names = array();
	$field_values = array();
    // Storing data in arrays to use loops
	foreach ($fields as $field) {
		$field_names[] = $field['name'];
		$field_values[] = $field['value'];
	}
    //The loop
	for ($i = 0; $i < count($field_names); $i++) {
		$message .= "**{$field_names[$i]}:** *{$field_values[$i]}*\n";
	}
    $data = [
        'content' => $message,
    ];

    $response = wp_safe_remote_post($webhook_url, [
        'body' => json_encode($data),
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);

    error_log(print_r($response, true));
}

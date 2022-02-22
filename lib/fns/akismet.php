<?php

namespace netmind\akismet;

// Check for AKISMET Key
if( ! defined( 'AKISMET_KEY' ) ){
  add_action( 'admin_notices', function(){
    $class = 'notice notice-error';
    $message = __( 'Missing Akismet API Key. Please add <code>define( \'AKISMET_KEY\', \'...\' );</code> to your <code>wp-config.php</code>.', 'netmind' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
  } );
}

/**
 * Checks an Elementor form submission for spam using Akismet
 *
 * @param      object  $record        The record
 * @param      object  $ajax_handler  The ajax handler
 */
function check_with_akismet( $record, $ajax_handler ){
  uber_log( '🔔 check_with_akismet() ' );

  $form_name = $record->get_form_settings( 'form_name' );

  $referrer = isset( $_POST['referrer'] ) ? $_POST['referrer'] : '';
  $comment = [
    'blog'            => site_url(),
    'user_ip'         => \ElementorPro\Core\Utils::get_client_ip(),
    'user_agent'      => $_SERVER['HTTP_USER_AGENT'],
    'referrer'        => $referrer,
    'permalink'       => $referrer,
    'comment_type'    => '',
  ];

  $raw_fields = $record->get( 'fields' );
  $fields = [];
  foreach( $raw_fields as $id => $field ){
    $fields[$id] = $field['value'];
  }

  $comment['comment_author'] = $fields['first_name'] . ' ' . $fields['last_name'];
  $comment['comment_author_email'] = $fields['email'];
  $comment['comment_author_url'] = '';

  $content = [];
  switch( strtolower( $form_name ) ){
    default:
      foreach( $raw_fields as $id => $field ){
        $content[] = $field['title'] . ': ' . $field['value'];
      }
      break;
  }
  $comment['comment_content'] = implode( "\n", $content );
  uber_log( '🔔 $comment = ' . print_r( $comment, true ) );

  $is_spam = fuspam( $comment, 'check-spam', AKISMET_KEY );

  uber_log( '🔔 $is_spam = ' . $is_spam );
  if( $is_spam ){
    $msg = 'Please do not abuse our forms.';
    $ajax_handler->add_error( 0, $msg );
    $ajax_handler->add_error_message( $msg );
    $ajax_handler->is_success = false;
  }
}
if( defined( 'AKISMET_KEY' ) )
  add_action( 'elementor_pro/forms/validation', __NAMESPACE__ . '\\check_with_akismet', 10, 2 );

/**
 * Check content with Akismet.
 *
 * @param      array        $comment  The comment array
 * @param      string       $type     The type of test to perform
 * @param      string       $key      Valid Akismet API Key
 *
 * @return     bool|string  `true` if spam, `false` if not or an error message if problems talking to the API.
 */
function fuspam( $comment , $type , $key ){
  $payload = http_build_query($comment);

  switch ($type)
    {
    case "verify-key":
      $call = "1.1/verify-key";
      $payload = "key={$key}&blog={$comment['blog']}";
      break;

    case "check-spam":
      $call = "1.1/comment-check";
      break;

    case "submit-spam":
      $call = "1.1/submit-spam";
      break;

    case "submit-ham":
      $call = "1.1/submit-ham";
      break;

    default:
      return "Error: 'type' not recognized";
      break;
    }

  $curl = curl_init("http://$key.rest.akismet.com/$call");

  curl_setopt($curl,CURLOPT_USERAGENT,"Fuspam/1.3 | Akismet/1.11");
  curl_setopt($curl,CURLOPT_TIMEOUT,5);
  curl_setopt($curl,CURLOPT_POSTFIELDS,$payload);
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

  $i = 0;
  do
    {
    $result = curl_exec($curl);

    if ($result === false)
      { sleep(1); }

    $i++;
    }
  while ( ($i < 6) and ($result === false) );

  if ($result === false)
    { $result = "Error: Repeat Failure"; }

  return $result;
}
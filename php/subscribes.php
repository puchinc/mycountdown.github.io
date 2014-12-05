<?php

/*
  |--------------------------------------------------------------------------
  | Subscription module
  |--------------------------------------------------------------------------
  |
  | These module are used when subscribing email from input text
  |
 */



/* SECTION I - CONFIGURATION */

$myFile = "../subscriptions.txt";
$date = date( "F j, Y, g:i a" );

/* SECTION II - CODE */
if ( ! empty( $_POST[ 'email' ] ) ) {
	$fh = fopen( $myFile, 'a' ) or die( "can't open file" );
	$stringData = ($_POST[ 'email' ]) . "            |              " . $date . "\r\n";
	if ( fwrite( $fh, $stringData ) )
		$result = "Your e-mail was added to subscriptions";
	else
		$result = "Operation could not be completed.";
	fclose( $fh );
}else {
	$result = "Please insert your email";
}
echo $result;
?>

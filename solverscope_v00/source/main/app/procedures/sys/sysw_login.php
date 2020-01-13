<?php

if ( $vld != 1 ) die();

$secret = svc_sanitize_post( $post['secret'] );
$name = svc_sanitize_post( $post['name'] );
$email = svc_sanitize_post( $post['email'] );
$profile = svc_sanitize_post( $post['profile'] ); 



//get DOMAIN_ID
$sql = "
	SELECT
		DOMAIN_ID
	FROM
		SYS_DOMAIN
	WHERE
		DOMAIN_SECRET = " . $secret . "
	";

	
$DOMAIN_ID = svc_get_var( $connection, $sql );
if ( strpos( strtolower( $DOMAIN_ID ), 'rror' ) > 0 ) {
	echo svc_error( 'sysw_login.php', 'Error 101' );
	die();
}
else if ( $DOMAIN_ID == '' ) {
	echo svc_error( 'sysw_login.php', 'Error 102' );
	die();
}




//get PERSON_ID
$sql = "
	SELECT
		PERSON_ID
	FROM
		SYS_PERSON
	WHERE
		PERSON_EMAIL = '" . $email . "'
	";
$PERSON_ID = svc_get_var( $connection, $sql );

if ( strpos( strtolower( $PERSON_ID ), 'rror' ) > 0 ) {
	echo svc_error( 'sysw_login.php', 'Error 103' );
	die();
}

else if ( $PERSON_ID == '' ) {
	
	//insert PERSON if not exists
	$sql = "
		INSERT INTO SYS_PERSON (
			PERSON_NAME,
			PERSON_EMAIL,
			PERSON_LAST_DOMAIN_ID
			) VALUES (
			'" . $name . "',
			'" . $email . "',
			" . $DOMAIN_ID . "	
			)
		";
	$res = svc_query( $connection, $sql );

	$sql = "
		SELECT
			MAX(PERSON_ID)
		FROM
			SYS_PERSON
		WHERE
			PERSON_LAST_DOMAIN_ID = " . $DOMAIN_ID . "
		";
	$PERSON_ID =  svc_get_var( $connection, $sql );
	
	
	$sql = "
		INSERT INTO SYS_PERPRO (
			PERPRO_DOMAIN_ID,
			PERPRO_PERSON_ID,
			PERPRO_PROFIL_ID
			) VALUES (
			" . $DOMAIN_ID . ",
			" . $PERSON_ID . ",
			" . $profile . "	
			)
		";
	$res = svc_query( $connection, $sql );
	
	
}



//save access
$sql = "
	INSERT INTO SYS_PERACC (
		PERACC_DOMAIN_ID,
		PERACC_PERSON_ID,
		PERACC_ADDR
		) VALUES (
		" . $DOMAIN_ID . ",
		" . $PERSON_ID . ",
		'" . $_SERVER['REMOTE_ADDR'] . "'
		)
	";
$res = svc_query( $connection, $sql );





//generate token
$tk = svc_encryp( $PERSON_ID, $cryp_key ); // $cryp_key @ svc_settings.php

svc_show_result( $tk );


?>






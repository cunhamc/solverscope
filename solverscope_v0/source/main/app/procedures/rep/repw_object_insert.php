<?php

if ( $vld != 1 ) die();

$parent = svc_sanitize_post( $post['parent'] );
$object_name = svc_sanitize_post( $post['object_name'] );
$object_type = svc_sanitize_post( $post['object_type'] );

//insert object
$sql = "
	INSERT INTO REP_OBJECT (
		OBJECT_NAME,
		OBJECT_FOLDER_ID,
		OBJECT_DOMAIN_ID,
		OBJECT_CREATED_BY,
		OBJECT_OBJTYP_ID,
		OBJECT_ACTIVE
	) VALUES (
		'" . $object_name . "',
		" . $parent . ",
		" . $DOMAIN_ID . ",
		" . $PERSON_ID . ",
		" . $object_type . ",
		0
	)
	";

$res = svc_query( $connection, $sql );

if ( $res != 1 ) {
	echo svc_error( 'repw_object_insert.php', 'Error 101' );
	die();
}


$OBJECT_ID = svc_get_var( $connection, "SELECT MAX(OBJECT_ID) FROM REP_OBJECT" );


//get object type name
$sql = "
	SELECT
		OBJTYP_NAME
	FROM
		REP_OBJTYP
	WHERE
		OBJTYP_ID = " . $object_type . "
	";

$OBJTYP_NAME = svc_get_var( $connection, $sql );



/********* OBJ_QUIZ **************************************************************************/

if  ( $OBJTYP_NAME == 'OBJ_QUIZ' ) {
	
	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$QUIITE_TXTITE_ID_COMMAND = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );
	
	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$QUIITE_TXTITE_ID_FEEDBACK = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );
	
	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$TXTITE_ID_OPT1 = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );

	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$TXTITE_ID_OPT2 = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );

	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$TXTITE_ID_OPT3 = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );

	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$TXTITE_ID_OPT4 = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );

	$sql = "INSERT INTO REP_TXTITE (TXTITE_DOMAIN_ID, TXTITE_CREATED_BY) VALUES (" . $DOMAIN_ID . ", " . $PERSON_ID . ")";
	svc_query( $connection, $sql );
	$TXTITE_ID_OPT5 = svc_get_var( $connection, "SELECT MAX(TXTITE_ID) FROM REP_TXTITE" );

	//insert item
	$sql = "
		INSERT INTO REP_QUIITE (
			QUIITE_DOMAIN_ID, 
			QUIITE_CREATED_BY, 
			QUIITE_OBJECT_ID, 
			QUIITE_TXTITE_ID_COMMAND, 
			QUIITE_TXTITE_ID_FEEDBACK
		) VALUES (
			" . $DOMAIN_ID . ",
			" . $PERSON_ID . ",
			" . $OBJECT_ID . ",
			" . $QUIITE_TXTITE_ID_COMMAND . ",
			" . $QUIITE_TXTITE_ID_FEEDBACK . "
		)
		";
	svc_query( $connection, $sql );
	$QUIITE_ID = svc_get_var( $connection, "SELECT MAX(QUIITE_ID) FROM REP_QUIITE" );
	
	//insert item options (default = 5)
	$sql = "
		INSERT INTO REP_QUIOPT 
			(QUIOPT_DOMAIN_ID, QUIOPT_CREATED_BY, QUIOPT_QUIITE_ID, QUIOPT_TXTITE_ID, QUIOPT_ORDERBY, QUIOPT_CORRECT) VALUES 
			(" . $DOMAIN_ID . "," . $PERSON_ID . "," . $QUIITE_ID . "," . $TXTITE_ID_OPT1 . ", 1, 1),
			(" . $DOMAIN_ID . "," . $PERSON_ID . "," . $QUIITE_ID . "," . $TXTITE_ID_OPT2 . ", 2, 0),
			(" . $DOMAIN_ID . "," . $PERSON_ID . "," . $QUIITE_ID . "," . $TXTITE_ID_OPT3 . ", 3, 0),
			(" . $DOMAIN_ID . "," . $PERSON_ID . "," . $QUIITE_ID . "," . $TXTITE_ID_OPT4 . ", 4, 0),
			(" . $DOMAIN_ID . "," . $PERSON_ID . "," . $QUIITE_ID . "," . $TXTITE_ID_OPT5 . ", 5, 0)
		";
	svc_query( $connection, $sql );
	
}

/********* OBJ_QUIZ_ASM **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_QUIZ_ASM' ) {

	//insert item
	$sql = "
		INSERT INTO REP_QUIASM (
			QUIASM_DOMAIN_ID, 
			QUIASM_CREATED_BY,
			QUIASM_OBJECT_ID
		) VALUES (
			" . $DOMAIN_ID . ",
			" . $PERSON_ID . ",
			" . $OBJECT_ID . "
		)
		";
	svc_query( $connection, $sql );

}



/********* OBJ_ESSAY **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_ESSAY' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_TEXT **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_TEXT' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_BOT **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_BOT' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_FILE **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_FILE' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_LTI **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_LTI' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_URL **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_URL' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_VIDEO **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_VIDEO' ) {

	/* WORK_IN_PROGRESS */

}



/********* OBJ_AUDIO **************************************************************************/

else if  ( $OBJTYP_NAME == 'OBJ_AUDIO' ) {

	/* WORK_IN_PROGRESS */

}








svc_show_result( 1 );


?>






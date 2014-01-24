<?php
 $routes = array(
	"/" => 'ShowsHandler', // "Normal" HTML handler
	"/show/delete/([0-9]+)" => 'ShowHandler', // Singular, only used for deletion
	"/shows/xml" => "ShowsXMLHandler", // XML Handler	
    "/shows" => "ShowXHRHandler",   // XHR Handler
);
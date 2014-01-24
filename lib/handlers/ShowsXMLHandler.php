<?php
/**
 * Renders the shows as XML
 * 
 * @return void
 */
class ShowsXMLHandler {
	/**
	* Renders all shows as XML in the browser.
	*
	* @method get
	* @return void
	*/
	function get() {
		$xml = Show::all_xml();
		Header('Content-type: text/xml');
		echo $xml->asXML();
	}
}
<?php 
/**
 * Delete show
 * This should be changed to a HTTP DELETE done via XHR
 */
class ShowHandler {
	/**
	 * Delete show by ID (HTTP)	 
	 *
	 * @method get	 
	 * @param int $id The ID to delete
	 * @return void
	 */
	function get($id) {
		$show = Show::find($id);
		$show->delete();
		header( 'Location: /' ) ;
	}
}
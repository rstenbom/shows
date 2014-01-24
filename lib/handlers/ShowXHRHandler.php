<?php 
/**
 * Read and create shows via XHR (JSON format)
 */
class ShowXHRHandler {
	/**
	 * Get all shows as JSON via XHR
	 *
	 * @method get_xhr
	 * @return void
	 */
	function get_xhr() {
		$shows = Show::find('all');
		// PHPActiveRecord returns the result as nested objects
		// Loop through for a "poormans"-serialization
		foreach ($shows as &$show) {
			$show = $show->to_array();
		}
		echo json_encode($shows);
	}
	/**
	 * Create a show using a XHR HTTP POST
	 *
	 * @method post_xhr
	 * @return void
	 */	
	function post_xhr() {		
		$show = new Show();
		$show->name 		= (isset($_POST['name'])) ? $_POST['name'] : null;
		$show->date 		= (isset($_POST['date'])) ? new ActiveRecord\DateTime($_POST['date']) : null;
		$show->start_time 	= (isset($_POST['starttime'])) ? $_POST['starttime'] : null;
		$show->synopsis 	= (isset($_POST['synopsis'])) ? $_POST['synopsis'] : null;
		$show->bline 		= (isset($_POST['bline'])) ? $_POST['bline'] : null;				
		$show->url 			= (isset($_POST['url'])) ? $_POST['url'] : null;
		$show->leadtext 	= (isset($_POST['leadtext'])) ? $_POST['leadtext'] : null;
		$show->save();
		echo $show->to_json();
	}
}

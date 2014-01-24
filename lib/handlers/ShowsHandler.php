<?php 
/**
 * The main handler for the application. Basically just displays all the shows in table format using twig.
 */
class ShowsHandler {	
	/**
	 * The twig loader 
	 */
	protected $loader;
	/**
	* The twig instance (uses the loader)
	*/
	protected $twig;  	
	
	/**
	 * Instantiates twig (templates)
	 *
	 * @method __construct
	 */
	public function __construct() {
		// Init twig (template "language")
		$this->loader = new Twig_Loader_Filesystem(__TEMPLATE_DIR__);
		$this->twig = new Twig_Environment($this->loader, array(		    
		    'cache' => __CACHE_DIR__
		));
	}	

	/**
	 * Render all the shows in table format on HTTP GET "/"
	 * 
	 * @method get 
	 * @return void
	 */
	function get() {				
		$shows = Show::find('all');
		// PHPActiveRecord returns the result as nested objects
		// Loop through for a "poormans"-serialization
		foreach ($shows as &$show) {
			$show = $show->to_array();
		}									
		echo $this->twig->render('index.html', array("shows" => $shows));		
	}
}

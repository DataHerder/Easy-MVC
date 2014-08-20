<?php
namespace Application;

// skeleton to the mvc bootstrap
class Bootstrap extends \EasyMVC\EasyMVCBootstrap{

	public function __construct() {
		parent::__construct();
	}

	/**
	 * This is a required function of the bootstrap where you setup your auto loading features
	 * for other libraries you want to link easily into the EasyMVC framework using the
	 * namespaces that already come with it
	 *
	 * @return mixed|void
	 */
	protected function _init()
	{
		// example function of how autoload is used
		// the parts of the path is shows as in the $parts array and passed
		// as reference, you can then manipulate the directory location
		// of the libraries by directly assigning to the $parts array
		$this->registerPath(function(&$parts){
			if ($parts[0] == 'DsnForm' || $parts[0] == 'SqlBuilder') {
				array_unshift($parts,'Modules');
				array_unshift($parts,'Application');
			}
		});
	}

	/**
	 * This is the hook class
	 *
	 * Right now it's only function really is to set the global database connection when the application
	 * loads.  The function $this->setModel($my_db_class) will then be used in the abstract model
	 * so every model you instantiate will have the instance of the database connection without instantiating
	 * it over and over and over again in your code.
	 *
	 * You can access this instantiation with $this->db when creating a Model class in the /Application/Models directory
	 * and extending the ModelAbstract class
	 *
	 * Example:
	 * $Bootstrap = get_bootstrap();
	 * $Sql= $Bootstrap->db;
	 *
	 */
	protected function _initHook()
	{
		// my model class
		#$Sql = new \SqlBuilder\Sql('mysql', 'host=localhost database=your_database user=root password=');
		#$Sql->setCharset();
		// set the global model
		#$this->setModel($Sql);
	}
}
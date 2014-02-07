<?php
/**
 * Part of Fuel Depot.
 *
 * @package    FuelDepot
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2012 Fuel Development Team
 * @link       http://depot.fuelphp.com
 */

namespace Admin;

/**
 * Administration dashboard
 */
class Controller_Admin extends \Controller_Base_Admin
{
	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		$data = array();

		// loop through the modules to find dashboard admin controllers
		
		
		foreach (glob(APPPATH.'../modules/*/classes/controller/admin/dashboard.php') as $controller) {
			// fetch the module name from the path found
			$controller = explode(DS,substr($controller, strlen(APPPATH)+3));
			$module = $controller[1];

			// and fetch the dashboard data
			try
			{
				$data[$module] = \Request::forge($module.'/admin/dashboard/index', false)->execute()->response()->body();
			}
			catch (\Exception $e)
			{
				var_dump($e);
			}
		}
		
	//	\Debug::dump($data);

		// and define the content body
		return \Theme::instance()
                        ->get_template()
                        ->set('title', 'Admin Dashboard')
                        ->set(  'content', 
                                \Theme::instance()->view('admin/dashboard')
                                ->set('dashboard', $data)
                            );
	}

}

/* End of file admin.php */

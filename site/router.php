<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_myrealpin
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class from com_wrapper
 *
 * @since  3.3
 */
class myrealpinRouter extends JComponentRouterBase
{
	/**
	 * Build the route for the com_myrealpin component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query)
	{
		if (isset($query['view']))
		{
			unset($query['view']);
		}

		return array();
	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		return array('view' => 'myrealpin');
	}
}

/**
 * myrealpin router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function myrealpinBuildRoute(&$query)
{
	$router = new myrealpinRouter;

	return $router->build($query);
}

/**
 * myrealpin router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function myrealpinParseRoute($segments)
{
	$router = new myrealpinRouter;

	return $router->parse($segments);
}

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
 * myrealpin view class.
 *
 * @since  1.5
 */
class myrealpinViewmyrealpin extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   1.5
	 */
	public function display($tpl = null)
	{
		$app    = JFactory::getApplication();
		$params = $app->getParams();

		// Because the application sets a default page title, we need to get it
		// right from the menu item itself
		$title = $params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($params->get('menu-meta_description'))
		{
			$this->document->setDescription($params->get('menu-meta_description'));
		}

		if ($params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $params->get('menu-meta_keywords'));
		}

		if ($params->get('robots'))
		{
			$this->document->setMetadata('robots', $params->get('robots'));
		}

		$myrealpin = new stdClass;
		$myrealpin->load = '';

		if($params->def('height_auto'))
		$this->SetJS();

		$myrealpin->url = $params->def('url', '');

		if ($params->def('show_header', 1))
		$myrealpin->url .= "&rp_header=1";
		else
		$myrealpin->url .= "&rp_header=0";

		if(strpos($myrealpin->url,"https://myrealpin") === false OR strpos($myrealpin->url,"rp_logon_guest") === false)
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_MYREALPIN_ERROR'), 'error');
			$myrealpin->url = 'https://myrealpin.com/more/docs-help/22-own-website';
			$params->set('scrolling', 1);
		}

		// Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));
		$this->params        = &$params;
		$this->myrealpin       = &$myrealpin;

		parent::display($tpl);
	}

	private function SetJS()
	{
		$document = JFactory::getDocument();
		$document->addScriptDeclaration("
		function setIframeHeightCO(id, ht) {
			var ifrm = document.getElementById(id);
			ifrm.style.visibility = 'hidden';
			ifrm.style.height = ht + 4 + \"px\"; // some IE versions need a bit added or scrollbar appears
			ifrm.style.visibility = 'visible';
			console.log(\"Iframe Resized!\");
		}

		function handleDocHeightMsg(e) {
			// parse data
			var data = JSON.parse( e.data );
			// check data object
			if ( data['docHeight'] ) {
				setIframeHeightCO( 'myrealpin', data['docHeight'] );
			}
		}

		window.addEventListener('message', handleDocHeightMsg, false);
		");
	}
}

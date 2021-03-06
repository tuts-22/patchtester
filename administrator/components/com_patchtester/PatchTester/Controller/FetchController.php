<?php
/**
 * Patch testing component for the Joomla! CMS
 *
 * @copyright  Copyright (C) 2011 - 2012 Ian MacLennan, Copyright (C) 2013 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

namespace PatchTester\Controller;

use PatchTester\Model\PullsModel;

/**
 * Controller class to fetch remote data
 *
 * @since  2.0
 */
class FetchController extends AbstractController
{
	/**
	 * Execute the controller.
	 *
	 * @return  void  Redirects the application
	 *
	 * @since   2.0
	 */
	public function execute()
	{
		// We don't want this request to be cached.
		$this->getApplication()->setHeader('Expires', 'Mon, 1 Jan 2001 00:00:00 GMT', true);
		$this->getApplication()->setHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true);
		$this->getApplication()->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0', false);
		$this->getApplication()->setHeader('Pragma', 'no-cache');
		$this->getApplication()->setHeader('Content-Type', $this->getApplication()->mimeType . '; charset=' . $this->getApplication()->charSet);

		$session = \JFactory::getSession();

		try
		{
			// Fetch our page from the session
			$page = $session->get('com_patchtester_fetcher_page', 1);

			$model = new PullsModel('com_patchtester.fetch', null, \JFactory::getDbo());

			// Initialize the state for the model
			$model->setState($this->initializeState($model));

			$status = $model->requestFromGithub($page);
		}
		catch (\Exception $e)
		{
			$response = new \JResponseJson($e);

			$this->getApplication()->sendHeaders();
			echo json_encode($response);

			$this->getApplication()->close(1);
		}

		// Store the last page to the session if given one
		if (isset($status['lastPage']) && $status['lastPage'] !== false)
		{
			$session->set('com_patchtester_fetcher_last_page', $status['lastPage']);
		}

		// Update the UI and session now
		if ($status['complete'] || $page === $session->get('com_patchtester_fetcher_last_page', false))
		{
			$status['complete'] = true;
			$status['header']   = \JText::_('COM_PATCHTESTER_FETCH_SUCCESSFUL', true);

			$message = \JText::_('COM_PATCHTESTER_FETCH_COMPLETE_CLOSE_WINDOW', true);
		}
		elseif (isset($status['page']))
		{
			$session->set('com_patchtester_fetcher_page', $status['page']);

			if ($session->has('com_patchtester_fetcher_last_page'))
			{
				$message = \JText::sprintf(
					'COM_PATCHTESTER_FETCH_PAGE_NUMBER_OF_TOTAL', $status['page'], $session->get('com_patchtester_fetcher_last_page')
				);
			}
			else
			{
				$message = \JText::sprintf('COM_PATCHTESTER_FETCH_PAGE_NUMBER', $status['page']);
			}

			unset($status['page']);
		}

		$response = new \JResponseJson($status, $message, false, true);

		$this->getApplication()->sendHeaders();
		echo json_encode($response);

		$this->getApplication()->close();
	}
}

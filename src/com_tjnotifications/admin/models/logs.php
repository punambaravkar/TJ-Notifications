<?php
/**
 * @package    Com_Tjnotifications
 * @copyright  Copyright (c) 2009-2019 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// No direct access to this file
defined('_JEXEC') or die;
jimport('joomla.application.component.model');
use Joomla\CMS\MVC\Model\ListModel;

/**
 * notifications model.
 *
 * @since  1.1.0
 */
class TjnotificationsModelLogs extends ListModel
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.1.0
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'tjl.id',
				'to', 'tjl.to',
				'key', 'tjl.key',
				'from', 'tjl.from',
				'cc', 'tjl.cc',
				'state', 'tjl.state',
				'subject', 'tjl.subject',
				'search'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.1.0
	 */
	protected function populateState($ordering = 'tjl.id', $direction = 'desc')
	{
		$app    = JFactory::getApplication();

		// Load the filter search
		$search = $app->getUserStateFromRequest($this->context . 'filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState($ordering, $direction);

		// Get pagination request variables
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');

		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('list.limit', $limit);
		$this->setState('list.start', $limitstart);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.1.0
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')
			->from($db->quoteName('#__tj_notification_logs', 'tjl'));

		$search = $this->getState('filter.search');

		// Filter by client
		$client = $this->getState('filter.client');

		if ($client)
		{
			$query->where($db->quoteName('tjl.client') . ' = ' . $db->quote($client));
		}

		// Filter by provider
		$provider = $this->getState('filter.provider');

		if ($provider)
		{
			$query->where($db->quoteName('tjl.provider') . ' = ' . $db->quote($provider));
		}

		// Filter by key
		$key = $this->getState('filter.key');

		if ($key)
		{
			$query->where($db->quoteName('tjl.key') . ' = ' . $db->quote($key));
		}

		// Filter by client
		$state = $this->getState('filter.state');

		if (is_numeric($state))
		{
			$query->where($db->quoteName('tjl.state') . ' = ' . $db->quote($state));
		}

		if (!empty($search))
		{
			$like = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
			$query->where($db->quoteName('tjl.subject') . ' LIKE ' . $like . ' OR ' . $db->quoteName('tjl.from') . ' LIKE ' . $like . ' OR ' . $db->quoteName('tjl.to') . ' LIKE ' . $like);
		}

		$orderCol  = $this->getState('list.ordering');
		$orderDirn = $this->getState('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->quoteName($orderCol) . ' ' . $db->escape($orderDirn));
		}

		return $query;
	}
}

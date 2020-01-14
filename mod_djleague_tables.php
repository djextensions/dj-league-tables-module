<?php
/**
 * @version $Id$
 * @package DJ-Events
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Events is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Events is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Events. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
require_once(JPATH_BASE.DS.'components'.DS.'com_djleague'.DS.'helpers'.DS.'djleague.php');
require_once(JPATH_BASE.DS.'components'.DS.'com_djleague'.DS.'helpers'.DS.'route.php');

$app = JFactory::getApplication();

$league = modDJLeagueTablesHelper::getLeague($params);
if($league === false) return; // $league not found, don't render module

$items = modDJLeagueTablesHelper::getItems($params);

DJLeagueHelper::setAssets();

$cparams = DJLeagueHelper::getParams();

$lang = JFactory::GetLanguage();
$lang->load('com_djleague');

require JModuleHelper::getLayoutPath('mod_djleague_tables', $params->get('layout','default'));

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
defined('_JEXEC') or die ('Restricted access');

class modDJLeagueTablesHelper
{
	static function getItems(&$params) {
    	
    	$items = array();
    	
    	JModelLegacy::addIncludePath(JPATH_BASE.'/components/com_djleague/models', 'DJLeagueModel');
    	$model = JModelLegacy::getInstance('Tables', 'DJLeagueModel', array('ignore_request'=>true));
		
    	$team = $params->get('team');
    	$limit = $params->get('limit', 0);
    	
    	$tournament = $params->get('tournament', $params->get('league'));
    	$model->setState('filter.tournament', $tournament);
    	
    	$season = $params->get('season', 1);
    	$model->setState('filter.season', $season);
    	
		$model->setState('filter.round', $params->get('round', 0));
		
		$model->setState('list.start', 0);
		$model->setState('list.limit', empty($team) ? $limit : 0);
		
		$model->setState('list.ordering', 'a.ordering');
		$model->setState('list.direction', 'asc');
		
		$items = $model->getItems();
		
		if($limit && !empty($team) && count($items) > $limit) {
			
			$team_pos = 0;
			foreach($items as $pos => $item) {
				if($item->team_id == $team) {
					$team_pos = $pos;
					break;
				}
			}
			
			//JFactory::getApplication()->enqueueMessage('<pre>'.print_r($items, true).'</pre>');
			
			if($team_pos < ceil($limit / 2)) {
				$items = array_slice($items, 0, $limit, true);
			} else if($team_pos > count($items) - ceil($limit / 2)) {
				$items = array_slice($items, count($items) - $limit, $limit, true);
			} else {
				$items = array_slice($items, $team_pos - floor($limit / 2), $limit, true);
			}
		}
		
		return $items;
	}
	
    static function getLeague(&$params) {
    	
    	$db = JFactory::getDbo();
    	
    	$tournament = (int)$params->get('tournament', $params->get('league'));
    	$season = (int)$params->get('season', 1);
    	
    	if($tournament && $season) {
    		
    		$db->setQuery('SELECT * FROM #__djl_leagues WHERE tournament_id='.$tournament.' AND season_id='.$season.' LIMIT 1');
    		$league = $db->loadObject();
    		if($league) {
    			$league->params = new JRegistry($league->params);
    		}
    		
    		return $league;
    	}
    	
    	return false;
    }
}

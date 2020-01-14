<?php
/**
 * @version 2.0.0.stable
 * @package DJ-ImageSlider
 * @subpackage DJ-ImageSlider Component
 * @copyright Copyright (C) 2012 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 *
 * DJ-ImageSlider is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-ImageSlider is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-ImageSlider. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die ('Restricted access'); 

$columns = $params->get('table_cols', array('played', 'score_diff', 'points'));
$team = (int) $params->get('team');
?>

<div class="mod_djl_tables djl_theme_<?php echo $cparams->get('theme','bootstrap') ?>">

<table class="table table-hover">

<thead>
		<tr>
			<th class="center" width="1%">
				<span class="djl_tooltip" title="<?php echo JText::_('COM_DJLEAGUE_POSITION'); ?>">
				<?php echo JText::_('COM_DJLEAGUE_POSITION_SHORT'); ?></span>
			</th>
			<th class="team_th">
				<?php echo JText::_('COM_DJLEAGUE_TEAM'); ?>
			</th>
			<?php foreach($columns as $col) { ?>
				<th class="<?php echo $col ?>_th center" width="5%">
					<span class="djl_tooltip" title="<?php echo JText::_('COM_DJLEAGUE_'.strtoupper($col)); ?>">
						<?php echo JText::_('COM_DJLEAGUE_'.strtoupper($col).'_SHORT'); ?>
					</span>
				</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $pos => $item) { ?>
			<tr<?php echo ($team == $item->team_id ? ' class="highlight_team"':'') ?>>
				<td class="position center">
					<?php echo $pos+1; ?>.
				</td>
				<td class="team">
					<?php if($params->get('show_logo', 1) && !empty($item->logo)) { ?>
						<img class="team_logo" src="<?php echo JURI::root(true).'/'.$item->logo ?>" alt="<?php echo htmlspecialchars($item->name) ?>" />
					<?php } ?>
					<?php echo htmlspecialchars($item->name); ?>
				</td>
				<?php foreach($columns as $col) { ?>
					<td class="<?php echo $col ?> center">
						<?php if($col == 'score_diff') {
							$sd = (int) $item->score_diff;
							$item->score_diff = ($sd > 0 ? '+':'').$sd;
						} ?>
						<?php echo $item->$col; ?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
	<?php if($params->get('show_link', 1)) { ?>
	<tfoot>
		<tr>
			<td class="tables_link" colspan="5">
				<a href="<?php echo JRoute::_(DJLeagueHelperRoute::getTablesRoute($params->get('tournament'), $params->get('season'))); ?>">
					<?php echo JText::_('COM_DJLEAGUE_TABLES_SEE_ALL'); ?></a>
			</td>
		</tr>
	</tfoot>
	<?php } ?>
</table>

</div>
<?php 
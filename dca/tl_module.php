<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.typolight.org>
 * @package    Calendar
 * @license    LGPL
 * @filesource
 */


/**
 * Add palettes to tl_module
 */
//$GLOBALS['TL_DCA']['tl_module']['palettes']['eventsattend'] = &$GLOBALS['TL_DCA']['tl_module']['palettes']['eventreader'];

$GLOBALS['TL_DCA']['tl_module']['palettes']['xkn_event_subscribe']    = '{title_legend},name,headline,type;{config_legend},xkn_event_sub_id,xkn_template;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['xkn_event_subscribe_list']    = '{title_legend},name,headline,type;{config_legend},xkn_event_sub_id,xkn_template;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['xkn_event_subscribe_reader']    = '{title_legend},name,headline,type;{config_legend},xkn_event_sub_id,xkn_template;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['xkn_event_subscribe_active']    = '{title_legend},name,headline,type;{config_legend},xkn_event_sub_id,xkn_template;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['xkn_event_sub_id'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['xkn_event_sub_id'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_events_subscribe', 'getEvents'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>false)
);
$GLOBALS['TL_DCA']['tl_module']['fields']['xkn_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['xkn_template'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'        		  => $this->getTemplateGroup('xkn_events_subscribe'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>false)
);

/**
 * Class tl_module_calendar
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.typolight.org>
 * @package    Controller
 */
class tl_module_events_subscribe extends Backend {

	/**
	 * Import the back end user object
	 */
	public function __construct() {
		parent::__construct();
		$this->import('BackendUser', 'User');
	}
	
	/*
	 * 
	 * 
	 */
	public function getEvents() {
		if (!$this->User->isAdmin && !is_array($this->User->calendars)) {
			return array();
		}

		$arrCalendars = array();
		$objCalendars = $this->Database->execute("SELECT id, title FROM tl_calendar_events WHERE register=1 ORDER BY title");

		while ($objCalendars->next()) {
			if ($this->User->isAdmin || $this->User->hasAccess($objCalendars->id, 'calendars')) {
				$arrCalendars[$objCalendars->id] = $objCalendars->title;
			}
		}

		return $arrCalendars;
	}

}

?>
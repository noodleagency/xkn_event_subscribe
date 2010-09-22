<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
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
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    ClubSEAT 
 * @license    GPL 
 * @filesource
 */


/**
 * Class ModuleEventSubscribeForm 
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class ModuleEventSubscribeForm extends Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_form';

	
	/**
	 * Generate module
	 */
	public function __construct($cfg) {	
		$this->import('FrontendUser', 'User');
		$this->import("Database");
		parent::__construct($cfg);


		$this->xkn_event_sub_id = $this->arrData['xkn_event_sub_id'];
	}

	/**
	 * Generate module
	 */
	public function compile() {
		
	}

	/**
	 * Generate module
	 */
	public function generate() {		
		$GLOBALS['TL_HEAD'][] = '<script type="text/javascript" src="system/modules/xkn_ajax/js/ajaxDispatcher.js"></script>';
		// recup id de l'event
		$tmp = new EventSubscribe($this->xkn_event_sub_id, $this->xkn_template);
//		print_r($tmp);
		return $tmp->loadForm();
	}

}

?>
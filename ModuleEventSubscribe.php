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
 * Class ModuleEventSubscribe 
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class ModuleEventSubscribe extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_list';

	/**
	 * constructeur
	 */
	public function __construct() {	
//		echo get_class($this)."::__construct";
	}
	
	/**
	 * Generate module
	 */
	public function compile()
	{
		
	}
	
	/**
	 * Generate module
	 */
	public function generate() {
		$this->Import('Input');	
		echo $this->Input->get('id').' '.get_class($this)."::generate";
		print_r($this);
		
	}
	
	public function getEventList($dca) {

		$this->Import('Database');
		$sql = 'SELECT id, title ';
		$sql .= 'FROM tl_calendar_events ';
		$sql .= 'WHERE register=1 ';
		$objEvt = $this->Database->prepare($sql)->execute();
		$obj = array();
		while($objEvt->next()) {
			$obj[] = $objEvt->title;
		}
//		print_r($obj);
		return $obj;
	}
	
	public function getMemberName($dca) {
		$this->Import('Database');
		$sql = 'SELECT m.firstname, m.lastname ';
		$sql .= 'FROM tl_calendar_events_subscribe AS ces ';
		$sql .= 'LEFT JOIN tl_member AS m ON ces.id_member=m.id ';
		$sql .= 'WHERE ces.id=? ';
		$objEvt = $this->Database->prepare($sql)->execute($id);
		$objEvt->FetchAssoc();
		return $objEvt->firstname.' '.$objEvt->lastname;
	}
	
}

?>
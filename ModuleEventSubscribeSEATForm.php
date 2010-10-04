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
 * Class ModuleEventSubscribeSEATForm 
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class ModuleEventSubscribeSEATForm extends Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTable = 'tl_calendar_events_subscribe';
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_seatform';

	/**
	 * Format de sortie
	 * @var string
	 */
	protected $strContentType = 'text/html';
	
	/**
	 * Liste des evenements ouverts aux inscriptions
	 * @var array
	 */
	protected $events = array();

	/**
	 * Liste des inscrits a un evenement
	 * @var array
	 */
	protected $sub = array();


	
	/**
	 * Compile module
	 */
	public function __construct($cfg) {
		
		$this->Import('Config');
		$this->Import('Input');
		$this->Import('Database');
//		print_r($this);
		parent::__construct($cfg);
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
		// recuperation des parametres
		$id_event = $this->xkn_event_sub_id;
		$id = $this->Input->get('id');
		$present = $this->Input->get('present');
		$date = strtotime($this->Input->get('date'));
		$tmp_data=array();
		if(!$id || !$date ) {
			// pas de parametres
			$tmp_data['result'] = -1;
		} else {
			if($present!=0 && $present!=1) {
				$present=1;
			}
			// Test si User existe
			$sql = 'SELECT id ';
			$sql .= 'FROM tl_member ';
			$sql .= 'WHERE id=? ';
			$usrObj = $this->Database->prepare($sql)->execute($id);
			if($usrObj->numRows==0) {
				// Cet User n'existe pas
				$tmp_data['result'] = 0;
			} else {
				// User existe
				// Test si User deja inscrit a cet evenement et a cette date
				$sql = 'SELECT ces.id ';
				$sql .= 'FROM `tl_calendar_events_subscribe` AS ces ';
				$sql .= 'WHERE ces.id_member=? ';
				$sql .= 'AND ces.ces_date=? ';
				$usrObj = $this->Database->prepare($sql)->execute($id, $date);
				if($usrObj->numRows==1) {
					// deja inscrit
					$tmp_data['result'] = 0;
				} else {
					// ajout 
					$q = 'INSERT INTO tl_calendar_events_subscribe ';
					$q .= '(tstamp, id_member, pid, ces_date, ces_referer, ces_present) ';
					$q .= 'VALUES ';
					$q .= '( ?, ?, ?, ?, ?, ?) ';
					$usrSave = $this->Database->prepare($q)->execute(time(), $id, $id_event, $date, 'SEAT', $present);
					$tmp_data['result'] = ($usrSave->__get('insertId')>0) ? 1 : 0;
				}
			}
		}		
		// generation du template
		$objTemplate = new FrontendTemplate($this->strTemplate, $this->strContentType);//, 
		$tmp_data['id_event'] = $this->xkn_event_sub_id;
		$objTemplate->setData($tmp_data);

		return $objTemplate->parse();

	}

	/**
	 * 
	 * @return unknown_type
	 */
	public function output() {
		parent::output();
	} // end output
	
} // end class

?>
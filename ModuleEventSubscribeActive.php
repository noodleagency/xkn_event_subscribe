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
 * Class ModuleEventSubscribeActive
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class ModuleEventSubscribeActive extends Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTable = 'tl_calendar_events_subscribe';
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_active';

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
		$id = $this->Input->get('id');
		$key = $this->Input->get('key');
		$date = strtotime($this->Input->get('date'));
		$present = $this->Input->get('present');
		if(!$id || !$key || ($present!=0 && $present!=1)) {
			// pas de parametres
			$tmp_data['result'] = -1;
		} else {
			$sql = 'SELECT ces.id ';
			$sql .= 'FROM `tl_calendar_events_subscribe` AS ces ';
			$sql .= 'LEFT JOIN `tl_member` AS m ON ces.id_member=m.id ';
			$sql .= 'WHERE ces.id_member=? ';
			$sql .= 'AND MD5(CONCAT(email, \'XXX\', ces.id))=? ';
			$usrObj = $this->Database->prepare($sql)->execute($id, $key);
			
			$tmp_data=array();
			if($usrObj->numRows==1) {
				// si key ok > changement statut
				$usrData = $usrObj->fetchAssoc();
				$q = 'UPDATE tl_calendar_events_subscribe SET ces_date=?, ces_present=? WHERE id=? ';
				$usrSave = $this->Database->prepare($q)->execute($date, $present, $usrData['id']);
				$tmp_data['result'] = $usrSave->__get('affectedRows');
			} else {
				$tmp_data['result'] = 0;
			}
		}
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
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
 * Class EventSubscribe 
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class EventSubscribe extends Controller
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_form';
	
	/**
	 * Template
	 * @var string
	 */
	protected $xkn_event_sub_id = 0;

	/**
	 * constructeur
	 */
	public function __construct($id=0, $template='xkn_events_subscribe_form') {
		$this->import("Database");	
        $this->import('FrontendUser', 'User');
        $this->strTemplate = $template;
		parent::__construct();
		$this->xkn_event_sub_id=$id;
	}

	/**
	 * Generate module
	 */
	protected function compile() {

	}

	/**
	 * 
	 * @return unknown_type
	 */
	public function generate() {

	}
	
	/**
	 * 
	 * @param unknown_type $id
	 * @return unknown_type
	 */
	public function loadForm() {
		// recup infos de l'event
		
		$objGallery = $this->Database->prepare("SELECT * FROM tl_calendar_events WHERE id=?")
										 ->limit(1)
										 ->execute($this->xkn_event_sub_id);

		$objTemplate = new FrontendTemplate($this->strTemplate);
		$objTemplate->xkn_event_sub_id = $this->xkn_event_sub_id;
		$tmp_data=$objGallery->fetchAssoc();
			// creation de la liste des jours
		$sub_day = array();
		$subStartDate = date('d', $tmp_data['startDate']);
		$subEndDate = date('d', $tmp_data['endDate']);
		for($j=$tmp_data['startDate']; $j<$tmp_data['endDate']; $j+=(60*60*24)) {
			$sub_day[] = array('stamp'=>$j, 'label'=>date("j/m/Y", $j));
		}
		$tmp_data['sub_date'] = $sub_day;
		$tmp_data['firstname'] = $this->User->firstname;
		$tmp_data['lastname'] = $this->User->lastname;
		$objTemplate->setData($tmp_data);
		
		return $objTemplate->parse();
		
	}
}

?>
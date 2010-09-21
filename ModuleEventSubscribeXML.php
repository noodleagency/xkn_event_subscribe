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
 * Class ModuleEventSubscribeXML 
 *
 * @copyright  Guillaume LEROY 
 * @author     Guillaume LEROY zegnoo@zegnoo.net 
 * @package    Controller
 */
class ModuleEventSubscribeXML extends Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTable = 'tl_calendar_events_subscribe';
	
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'xkn_events_subscribe_xml';

	/**
	 * Format de sortie
	 * @var string
	 */
	protected $strContentType = 'text/xml';
	
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
	 * Nombre d'evenements ouverts aux inscriptions
	 * @var int
	 */
	protected $num_events = 0;
	
	/**
	 * @var int
	 */
	protected $perPage = 20;

	
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
	 * Compile module
	 */
	public function compile() {		
		$this->loadDataContainer('tl_form_field');
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/cd_collection/html/ajax.js';
		$strReturn = "Ajax Return";
		if ($this->Input->get('isAjax') == '1') {
			print $strReturn;
			exit; // IMPORTANT!
		}
	}

	/**
	 * Generate module
	 */
	public function generate() {
		
		$this->getEventSubscription($this->xkn_event_sub_id);
		
		$objTemplate = new FrontendTemplate($this->strTemplate, $this->strContentType);//, 
		$objTemplate->id_event = $this->xkn_event_sub_id;
		$tmp_data['id_event'] = $this->xkn_event_sub_id; 
		$tmp_data['sub'] = $this->sub; 
		$objTemplate->setData($tmp_data);

		return $objTemplate->parse();
		
		
		
		if (TL_MODE == 'BE') {
			
			if($this->Input->get('table')=="tl_calendar_events_subscribe") {
				if($this->Input->get('act')=="del") {
					$this->delEventSubscription($this->Input->get('id'), $this->Input->get('member'));
					header('Location: main.php?do=tl_calendar_events_subscribe&table=tl_calendar_events_subscribe&id='.$this->Input->get('id'));
					die('');
				}
				return $this->loadEventData($this->Input->get('id'));
			}
			
			$page = $this->Input->get('page') ? $this->Input->get('page') : 1;
			$offset = ($page - 1) * $this->perPage;
			$this->length = $this->Input->get('num')>0 ? 0+$this->Input->get('num') : $this->perPage ;
			$this->events = $this->loadEvents($offset, $this->length);

			$objTemplate = new BackendTemplate($this->strTemplate);
			$objTemplate->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
			$objTemplate->del_msg = $GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subdel'] ;
			$objTemplate->referer = 'typolight/main.php?do=tl_calendar_events_subscribe';
			$objTemplate->wildcard = '### EVENT LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->calendar = 'test';
			$objTemplate->link = 'link';
			$objTemplate->events = $this->events;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

//			print_r($this);
			
			// Pagination
			if ($this->perPage > 0) {
				$limit = $this->perPage;	 
				// Get total number of events
				$this->num_events = $this->countEvents();				
				// Add pagination menu
				$objPagination = new Pagination($this->num_events, $this->perPage);
				$objTemplate->pagination = $objPagination->generate("\n  ");
			}
			
			return $objTemplate->parse();
		}
		return parent::generate();
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Template
	 */
	public function loadEventData($id=0) {
			$evt = $this->getEvent($id);
			$sub = $this->getEventSubscription($id);
			$num_sub = $this->countEventSubscription($id);

//			print_r($evt);
			
			$objTemplate = new BackendTemplate('mod_event_subscribe');
			$objTemplate->back = $GLOBALS['TL_LANG']['MSC']['goBack'];
			$objTemplate->referer = 'javascript:history.go(-1)';
			$objTemplate->wildcard = '### EVENT LIST ###';
			$objTemplate->title = $evt['title'];
			$objTemplate->headline = $evt['teaser'];
			$objTemplate->id = $this->id;
			$objTemplate->date_from = date('d/m/Y', $evt['startDate']);
			$objTemplate->date_to = date('d/m/Y', $evt['endDate']);
			$objTemplate->calendar = 'test';
			$objTemplate->link = 'link';
			$objTemplate->entries = $evt;
			$objTemplate->num_sub = $num_sub;
			$objTemplate->sub = $sub;
//			$objTemplate->referer = 'typolight/main.php?do=tl_calendar_events_subscribe';
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			// Pagination
			if ($this->perPage > 0) {
				$limit = $this->perPage;	 
				// Get total number of events
//				$this->num_events = $this->countEvents();				
				// Add pagination menu
				$objPagination = new Pagination($num_sub, $this->perPage);
				$objTemplate->pagination = $objPagination->generate("\n  ");
			}
			
			return $objTemplate->parse();
	} // end loadEventData
	
	/**
	 * 
	 * @param int $id
	 * @return array
	 */
	public function getEvent($id=0) {
		$sql = 'SELECT * FROM tl_calendar_events WHERE id=? ';
		$objEvt = $this->Database->prepare($sql)->execute($id);
		return $objEvt->fetchAssoc();
	} // end getEvent
	
	/**
	 * 
	 * @param int $id
	 * @return int
	 */
	public function countEventSubscription($id=0) {
		$sql = 'SELECT COUNT(id) AS num FROM tl_calendar_events_subscribe WHERE pid=? ';
		$objEvt = $this->Database->prepare($sql)->execute($id);
		$obj = $objEvt->fetchAssoc();
		return $obj['num'];
	} // end countEventSubscription
	
	/**
	 * Liste des inscrits a un event
	 * 
	 * @param int $id ID de l'evenement
	 * @param int $start offset de depart de la liste
	 * @param int $length ID nombre d'inscrits a afficher
	 * @return array
	 */
	public function getEventSubscription($id=0, $start=0, $length=20) {
		
		$this->sub = array();
		$sql = 'SELECT ces.*, m.firstname, m.lastname, m.email, m.groups ';
		$sql .= 'FROM tl_calendar_events_subscribe AS ces ';
		$sql .= 'LEFT JOIN tl_member AS m ON ces.id_member=m.id ';
//		$sql .= 'LEFT JOIN tl_member_group AS mg ON m.groups=mg.id ';
		$sql .= 'WHERE ces.pid=? ';
		$sql .= 'ORDER BY ces_date ASC ';
		$sql .= 'LIMIT ?, ? ';
//		echo $sql; 
		$objEvt = $this->Database->prepare($sql)->execute($id, $start, $length);
		while($objEvt->next()) {
			$groups = deserialize($objEvt->groups);
			$grp_val = array();
			for($i=0; $i<count($groups);$i++) {
				$q = 'SELECT name FROM tl_member_group WHERE id='.$groups[$i];
				$objGrp = $this->Database->prepare($q)->execute();
				while($objGrp->next()) {
					$grp_val[] = $objGrp->name;
				}
			}
			$tmp = array();
			$tmp['id'] = $objEvt->id;
			$tmp['pid'] = $objEvt->pid;
			$tmp['id_member'] = $objEvt->id_member;
			$tmp['firstname'] = $objEvt->firstname;
			$tmp['lastname'] = $objEvt->lastname;
			$tmp['email'] = $objEvt->email;
			$tmp['group'] = $grp_val;
			$tmp['date'] = $objEvt->ces_date;
			$tmp['sub_date'] = $objEvt->tstamp;
			$tmp['referer'] = $objEvt->ces_referer;
//			$tmp['present'] = $GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['present'][$objEvt->ces_present];
			$tmp['present'] = $objEvt->ces_present;
			array_push($this->sub, $tmp);
		}
		return $this->sub;
	} //end getEventSubscription
	
	/**
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @param integer $id_member ID de l'utilisateur
	 * @return void
	 */
	public function delEventSubscription($id_event=0, $id_member=0) {
		$sql = 'DELETE FROM tl_calendar_events_subscribe WHERE pid=? AND id_member=? ';
		$objEvt = $this->Database->prepare($sql)->execute($id_event, $id_member);
	} // delEventSubscription
		
	/**
	 * Liste des events proposant une inscription
	 * 
	 * @param int $start
	 * @param int $length
	 * @return array
	 */
	public function loadEvents($start=0, $length=1) {
//		echo get_class($this)."::loadEvents";
		$sql = 'SELECT * FROM tl_calendar_events WHERE register=1 LIMIT ?,? ';
		$objEvt = $this->Database->prepare($sql)->execute($start, $length);
		while($objEvt->next()) {
			$tmp = array();
			$tmp['id'] = $objEvt->id;
			$tmp['pid'] = $objEvt->pid;
			$tmp['tstamp'] = $objEvt->tstamp;
			$tmp['title'] = $objEvt->title;
			$tmp['teaser'] = $objEvt->teaser;
			$tmp['startTime'] = $objEvt->startTime;
			$tmp['endTime'] = $objEvt->endTime;
			$tmp['startDate'] = $objEvt->startDate;
			$tmp['endDate'] = $objEvt->endDate;
			$tmp['formId'] = $objEvt->formId;
			$tmp['formHeadline'] = $objEvt->formHeadline;
			$tmp['freeHeadline'] = $objEvt->freeHeadline;
			$tmp['showFree'] = $objEvt->showFree;
			$this->events[] = $tmp;
		}
		return $this->events;
	} // end countEvents
	
	/**
	 * Nombre total d'inscrits a un event 
	 * 
	 * @return array
	 */
	public function countEvents() {
		$sql = 'SELECT COUNT(id) AS num FROM tl_calendar_events WHERE register=1';
		$objEvt = $this->Database->prepare($sql)->execute($length, $start);
		$obj = $objEvt->fetchAssoc();
		return $obj['num'];
	} // end countEvents
	
	/**
	 * callback d'ajout du formulaire d'inscription a la liste des events
	 * @return array
	 */
	function loadEventForm($arrEvents, $arrCalendars, $intStart, $intEnd) {
		ksort($arrEvents);
		while(list($k, $v)= each($arrEvents)) {
			while(list($sk, $sv)= each($v)) {
				for($i=0;$i<count($sv);$i++) {
					if($sv[$i]['register']==1) {
						$num_in = $this->countEventSubscription($sv[$i]['id']);
						$num_max = $sv[$i]['max_register'];
						$usr_in =  $this->subscribed($sv[$i]['id']);
						
						if($usr_in==1) {
							// User deja inscrit -> affichage de la date
							$usr_evt = $this->get_subscribe_date($sv[$i]['id']);
							$tmpForm = new FrontendTemplate('mod_event_subscribe_done');
							$sv[$i]['subform_head'] = ($GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subscribed']);
							$sv[$i]['headline'] = (sprintf($GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subscribed_headline'], date('d/m/Y', $usr_evt['ces_date'])));
						} else if($num_max<=$num_in) {
							// User non inscrit mais plus de place -> msg full
							$sv[$i]['txt'] = &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['full'];
							$tmpForm->setData($sv[$i]);
							$tmpForm = new FrontendTemplate('mod_event_subscribe_full');
						} else {						
							// User non inscrit & place disponible -> formulaire d'inscription
							$tmpForm = new FrontendTemplate('mod_event_subscribe_form');
							// creation de la liste des jours
							$sub_day = array();
							$subStartDate = date('d', $sv[$i]['startDate']);
							$subEndDate = date('d', $sv[$i]['endDate']);
							for($j=$sv[$i]['startDate']; $j<$sv[$i]['endDate']; $j+=(60*60*24)) {
								$sub_day[] = array('stamp'=>$j, 'label'=>date("j/m/Y", $j));
							}
							$sv[$i]['sub_day'] = $sub_day;
	
							$sv[$i]['subform_head'] = &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subscribe_form_header'];
							$sv[$i]['subgo_label'] = &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subscribe_bt'];
							$sv[$i]['subselect_label'] = &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subscribe_date'];
						}
//						print_r($sv[$i]);
						$tmpForm->setData($sv[$i]);
						$arrEvents[$k][$sk][$i]['formHeadline']= $tmpForm->parse();
					}
				}
			}
		}
		return $arrEvents;
	} // end loadEventForm
	
	/**
	 * verification si User deja inscrit a cet evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return boolean
	 */
	public function subscribed($id_event=0) {
		$this->import('FrontendUser', 'User');
		$sql = "SELECT id ";
		$sql .= "FROM tl_calendar_events_subscribe ";
		$sql .= "WHERE id_member=? ";
		$sql .= "AND pid=? ";
		$event_usr = $this->Database->prepare($sql)->execute($this->User->id, $id_event);
		return ($event_usr->numRows>0);
	}	
	
	
	/**
	 * verification si User deja inscrit a cet evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return boolean
	 */
	public function get_subscribe_date($id_event=0) {
		$this->import('FrontendUser', 'User');
		$sql = "SELECT * ";
		$sql .= "FROM tl_calendar_events_subscribe ";
		$sql .= "WHERE id_member=? ";
		$sql .= "AND pid=? ";
		$event_usr = $this->Database->prepare($sql)->execute($this->User->id, $id_event);
		return $event_usr->fetchAssoc();
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
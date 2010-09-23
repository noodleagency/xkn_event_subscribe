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
 * @copyright  2010 - Kantik / Noodle 
 * @author     Erwan Ripoll 
 * @package    seat_catalog 
 * @license    GPL 
 * @filesource
 */


/**
 * Class AjaxModuleEventSubscribeAdmin 
 *
 * @copyright  2010 - Kantik / Noodle 
 * @author     Erwan Ripoll 
 * @package    Controller
 */
class AjaxModuleEventSubscribe extends Controller {

	public function __construct() {
		$this->import('FrontendUser', 'User');

 		if($GLOBALS['XKN_MODULES']['XKN_JOURNAL']['installed']) { $this->import('Journal'); $this->import('FrontendUser', 'User');}		

		parent::__construct();

		$this->User->authenticate();
		$this->import('Database');
		
	}

	/**
	 * verification si User deja inscrit a cet evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return boolean
	 */
	public function subscribed($id_event=0, $date='0') {
		$this->import('FrontendUser', 'User');
		$sql = "SELECT id ";
		$sql .= "FROM tl_calendar_events_subscribe ";
		$sql .= "WHERE id_member=? ";
//		$sql .= "AND ces_date=? ";
		$sql .= "AND pid=? ";
		$event_usr = $this->Database->prepare($sql)->execute($this->User->id, $id_event); //$date, 
		return ($event_usr->numRows>0);
	}
	
	/**
	 * retourne le nombre total de places disponibles de l'evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return integer
	 */
	public function get_event_room($id_event=0) {
		$sql = "SELECT max_register ";
		$sql .= "FROM tl_calendar_events ";
		$sql .= "WHERE id=? ";
		$tmp_event = $this->Database->prepare($sql)->execute($id_event);
		$event = $tmp_event ->fetchAssoc();
		return $event['max_register'];
	}
	
	/**
	 * retourne le nombre d'inscrits a un evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return integer
	 */
	public function get_subscribed($id_event=0) {
		$sql = "SELECT COUNT(DISTINCT id) AS num ";
		$sql .= "FROM tl_calendar_events_subscribe ";
		$sql .= "WHERE pid=? ";
		$tmp_event = $this->Database->prepare($sql)->execute($id_event);
		$event = $tmp_event ->fetchAssoc();
		return $event['num'];
	}
	
	/**
	 * annule une  inscription a un evenement
	 * 
	 * @param integer $id_event ID de l'evenement
	 * @return void
	 */
	public function unsubscribe($id_event=0) {
		$this->import('FrontendUser', 'User');
		$sql = "DELETE ";
		$sql .= "FROM tl_calendar_events_subscribe ";
		$sql .= "WHERE id_member=? ";
		$sql .= "AND pid=? ";
		$event = $this->Database->prepare($sql)->execute($this->User->id, $id_event);
		return $event;
	}
	
	/**
	 * 
	 * @param array $_params
	 * @return unknown_type
	 */
	public function eventSubscribe($_params) {	
		global $objPage;

		// recup des infos du client
		$this->import('FrontendUser', 'User');
		$this->import('String');
		
		// recup du template pour le message de retour
		$objTemplate = new FrontendTemplate('xkn_events_subscribe_return');
		$tmp_data=array();

		// chargement des fichiers de traduction
		$this->loadLanguageFile('default', $this->Input->get('fr'));
		$postAction='';
		
		if($this->subscribed($_params['event'], $_params['subdate'])) {			
			// verif si deja inscrit
			$tmp_data['data'] = "Msg d'erreur : deja inscrit";
			$objTemplate->setData($tmp_data);
			$content = $objTemplate->parse();		
			return array('status' => 'OK', 'content' => $content , 'postAction' => $postAction) ;
		}
		
		// recuperation du nombre d'inscrits  l'evenement
		$num_usr = $this->get_subscribed($_params['event']);
		
		// recuperation du nombre total de places disponibles pour l'evenement
		$max_usr = $this->get_event_room($_params['event']);

		if($num_usr>=$max_usr) {
			// Si plus de places libres
			$tmp_data['data'] = "Msg d'erreur : Plus de place";
			$objTemplate->setData($tmp_data);
			$content = $objTemplate->parse();
			return array('status' => 'OK', 'content' => $content , 'postAction' => $postAction) ;
		}
		
		// Places libres & pas inscrit -> inscription
		$sql = "INSERT INTO tl_calendar_events_subscribe (tstamp, id_member, pid, ces_date, ces_referer) VALUES (?, ?, ?, ?, ?)";
		$_module = $this->Database->prepare($sql)
							->execute(time(), $this->User->id, $_params['event'], $_params['subdate'], $_params['from']  );
		$tmp_data['data'] = sprintf($GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['subdone'] , date('d/m/Y', $_params['subdate']));
		$objTemplate->setData($tmp_data);
		$content = $objTemplate->parse();
		return array('status' => 'OK', 'content' => $content , 'postAction' => $postAction) ;
		
	}

} // end class

?>
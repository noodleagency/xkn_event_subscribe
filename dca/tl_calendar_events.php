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
 * Table tl_calendar_events 
 */
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations'], 3, array
	(
			'group' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['group'],
				// send to tl_formstorage table editing
				'href'                => 'do=xkn_event_subscribe&table=tl_calendar_events_subscribe',
				'icon'                => 'system/modules/xkn_event_subscribe/html/eventsattend.gif',
   				'button_callback'     => array('tl_calendar_events_subscribe', 'groupButton')
			)
	)
);

// Selector type
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'][] = 'register';
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']. ';{legend_register},register';

$GLOBALS['TL_DCA']['tl_calendar_events']['ctable'][] = 'tl_calendar_events_subscribe';


// Insert new subpalettes after position 2
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes'], 2, array
	(
			'register'								=> 'formId,formHeadline,lastDate,max_register,showFree,freeHeadline',
	)
);



// Insert new Fields after position 12
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['fields'], 12, array
	(
		'register' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['register'],
			'exclude'                 => true,
			'default'                 => '',
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array('submitOnChange'=>true)
		),
/*			
		'formId' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['formId'],
			'exclude'                 => true,
			'inputType'               => 'radio',
			'foreignKey'              => 'tl_form.title',
			'eval'                    => array()
		),
*/
		'formHeadline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['formHeadline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'inputUnit',
			'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
			'eval'                    => array('maxlength'=>255)
		),

		'lastDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['lastDate'],
			'exclude'                 => true,
			'default'                 => time(),
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'maxlength'=>10, 'rgxp'=>'date', 'datepicker'=>$this->getDatePickerString(16))
		),

		'showFree' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['showFree'],
			'exclude'                 => true,
			'default'                 => '',
			'inputType'               => 'checkbox',
		),		

		'freeHeadline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['freeHeadline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'inputUnit',
			'options'                 => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
			'eval'                    => array('maxlength'=>255)
		),

		'max_register' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['max_register'],
			'exclude'                 => true,
			'default'                 => 100,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'maxlength'=>10, 'rgxp'=>'digit')
		)
		
	)
);

/**
 * 
 * @author zegnoo
 *
 */
class tl_calendar_events_subscribe extends Backend {

	/**
	 * Generate module
	 */
	public function __construct() {
		
	}
	
	/**
	 * 
	 * @param unknown_type $row
	 * @param unknown_type $href
	 * @param unknown_type $label
	 * @param unknown_type $title
	 * @param unknown_type $icon
	 * @param unknown_type $attributes
	 * @return unknown_type
	 */
	public function groupButton($row, $href, $label, $title, $icon, $attributes)
	{
//		echo get_class($this)."::groupButton";
		if ($row['register']) {
			// send to tl_form_auto editing => set formId as the id to edit 
			return '<a href="typolight/main.php'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
		} else {
			return '';
		}
	} 

}

?>
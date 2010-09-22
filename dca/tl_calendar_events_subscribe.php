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
 * Table tl_calendar_events_subscribe 
 */
$GLOBALS['TL_DCA']['tl_calendar_events_subscribe'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'               		  => 'tl_calendar_events',
		'enableVersioning'            => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 5,
			'fields'                  => array('id', 'id_member', 'ces_date', 'ces_present' ),
			'headerFields'			  => array('id', 'id_member', 'ces_date', 'ces_present' ),
			'panelLayout'			  => 'sort,filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('id', 'id_member', 'ces_date', 'ces_present' ),
			'format'                  => '%s %s %s %s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
/*			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),*/
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => 'pid, id_member,ces_date,ces_present'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id_member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['id_member'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'foreignKey'			  => 'tl_member.lastname',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'pid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['pid'],
			'exclude'                 => true,
			'inputType'               => 'select',
//			'input_field_callback'    => array('ModuleEventSubscribe', 'getEventList'),
//			'foreignKey'			  => 'tl_calendar_events.title',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'ces_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['ces_date'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'ces_present' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events_subscribe']['ces_present'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'option'				  => array('0', '1'),
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		)
	)
);

?>
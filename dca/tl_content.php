<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This is the data container array for table tl_content.
 *
 * PHP version 5
 * @copyright		2010 - Kantik / Noodle 
 * @author			Erwan Ripoll <eripoll@noodle.fr>
 * @package			Galleries 
 * @license			GPL 
 * @filesource
 */

/**
 * Add fields to tl_content
 */
/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['xkn_event_sub_id'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['xkn_event_sub_id'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_events_subscribe', 'getEvents'),
	'eval'                    => array('mandatory'=>true, 'multiple'=>false)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['xkn_event_sub'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['xkn_event_sub'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_calendar_events.title',
	'eval'                    => array('multiple'=>false, 'mandatory'=>true)
);

$GLOBALS['TL_DCA']['tl_content']['palettes']['content_xkn_event_sub'] = 'xkn_event_sub';


$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'xkn_event_sub';



?>
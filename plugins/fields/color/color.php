<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Color
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);

/**
 * Fields Color Plugin
 *
 * @since  3.7.0
 */
class PlgFieldsColor extends FieldsPlugin
{
	/**
	 * Change the default value field to a color field
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		$type = (is_object($data)) ? $data->type : $data['type'];

		if ($form->getName() == 'com_fields.fieldcom_content.article' &&  $type == 'color')
		{
			$form->setFieldAttribute('default_value', 'type', 'color');
		}

		return true;
	}
}

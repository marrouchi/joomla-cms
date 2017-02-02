<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.Menu
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Menu Plugin
 *
 * @since  3.2
 */
class PlgContentMenu extends JPlugin
{
	/** Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;
	/**
	 * Check if menu item alias has been changed. If so, display a message that suggests
	 * to add the old alias to the redirection table to automatically redirect the old url
	 * to the new one.
	 *
	 * @param   string   $context   The context of the content passed to the plugin (added in 1.6)
	 * @param   object   $menuItem  A JTableContent object
	 * @param   boolean  $isNew     If the content is just about to be created
	 *
	 * @return  boolean   true if function not enabled, is in frontend or is new. Else true or
	 *                    false depending on success of save function.
	 *
	 * @since   1.6
	 */
	public function onContentbeforeSave($context, $menuItem, $isNew)
	{
		if (!$isNew && $context == 'com_menus.item')
		{
			$menu = & JSite::getMenu();
			$old_alias = $menu->getItem($menuItem->id)->alias;
			
			if ($menuItem->alias != $old_alias)
			{
				$link = JRoute::_('index.php?option=com_redirect&view=link&layout=edit&old_alias=' . $old_alias . '&new_alias=' . $menuItem->alias);
				$message = JText::sprintf('PLG_CONTENT_MENU_ALIAS_UPDATE_WARNING', $link);
				JFactory::getApplication()->enqueueMessage($message, 'warning');
			}
		}

		return true;
	}

	/**
	 * Adds default values to the redirection editing form
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			
			return false;
		}

		// Get default values from GET params
		$app = JFactory::getApplication();
		
		if ($form->getName() == 'com_redirect.link'
			&& empty($data->id)
			&& $app->input->getString('old_alias', '')
			&& $app->input->getString('new_alias', ''))
		{
			$data->old_url = JURI::root() . $app->input->getString('old_alias');
			$data->new_url = JURI::root() . $app->input->getString('new_alias');
		}

		return true;
	}
}

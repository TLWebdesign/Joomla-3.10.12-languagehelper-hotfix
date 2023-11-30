<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Installer\Installer;

class  languagehotfixInstallerScript
{
    function preflight($type, $parent)
    {
        // Define the path to the target file in Joomla installation
        $targetFile = JPATH_LIBRARIES . '/src/Language/LanguageHelper.php';

        // Define the path to your replacement file in your package
        $replacementFile = $parent->getParent()->getPath('source') . '/LanguageHelper.php';

        // Check if replacement file exists
        if (!file_exists($replacementFile)) {
            JError::raiseWarning(500, "Replacement LanguageHelper.php not found in the package at: $replacementFile");

            return false;
        }

        // Replace the file
        if (!File::copy($replacementFile, $targetFile)) {
            JError::raiseWarning(500, "Error replacing LanguageHelper.php from $replacementFile to $targetFile");

            return false;
        }

        // Display a success message with the path information
        Factory::getApplication()->enqueueMessage(
            "LanguageHelper.php replaced successfully. New file placed at: $targetFile",
            'message'
        );

        // Remove this plugin to leave no trace
        $this->uninstallPlugin();

        return true;
    }

    private function uninstallPlugin()
    {
        $plugins = $this->findThisPlugin();
        foreach ($plugins as $plugin) {
            Installer::getInstance()->uninstall($plugin->type, $plugin->extension_id);
        }
    }

    private function findThisPlugin()
    {
        $db    = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select(array('extension_id', 'type'))
            ->from('#__extensions')
            ->where($db->quoteName('element') . ' = ' . $db->quote('languagehotfix'))
            ->where($db->quoteName('type') . ' = ' . $db->quote('file'));
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}

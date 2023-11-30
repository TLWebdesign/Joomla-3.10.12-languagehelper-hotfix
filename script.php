<?php
defined('_JEXEC') or die;

class  languagehotfixInstallerScript
{
    function preflight($type, $parent) {

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
        if (!JFile::copy($replacementFile, $targetFile)) {
            JError::raiseWarning(500, "Error replacing LanguageHelper.php from $replacementFile to $targetFile");
            return false;
        }

        // Display a success message with the path information
        JFactory::getApplication()->enqueueMessage("LanguageHelper.php replaced successfully. New file placed at: $targetFile", 'message');

        // Remove this plugin to leave no trace
        $this->uninstallPlugin();

        return true;
    }

    private function uninstallPlugin()
    {
        $plugins = $this->findThisPlugin();
        foreach ($plugins as $plugin) {
            \JInstaller::getInstance()->uninstall($plugin->type, $plugin->extension_id);
        }
    }

    private function findThisPlugin()
    {
        $db = \JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('extension_id')
            ->select('type')
            ->from('#__extensions')
            ->where("`element` = 'languagehotfix'")
            ->where("`type` = 'file'");

        $db->setQuery($query);

        return $db->loadObjectList();
    }
}

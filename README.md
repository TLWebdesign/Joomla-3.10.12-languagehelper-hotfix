THIS REPO IS OBSOLETE AND YOU SHOULD USE THIS ONE INSTEAD: https://github.com/TLWebdesign/Joomla-3-EOL-Security-Fixes


# Joomla-3.10.12 LanguageHelper.php Hotfix
 
This little plugin will help you update the LanguageHelper file with the security fix i backported from Joomla 4.4.1 More info on the vulnerability here: https://developer.joomla.org/security-centre/919-20231101-core-exposure-of-environment-variables.html

## Donate to the joomla project!
If this plugin saved you valuable time please consider donating something to the joomla project: https://community.joomla.org/donate. 
Especially agencies who will save tons of time when they have multiple websites still on J3. Any donation is much appreciated.

## Backup First!
Always try this fix first on a test environment because it could potentially break language files that were not following exact specification. Previously these language files would still work but in fixing the vulnerability the strictness of how these files are processed makes it that a language string can not have new lines in the content anymore.

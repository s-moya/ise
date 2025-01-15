<?php


/**
 * language.php
 *
 * The language definitions.
 *
 * PHP versions 5
 *
 * @author    Alexander Schneider <alexanderschneider85@gmail.com>
 * @copyright 2008-2017 Alexander Schneider
 * @license   http://www.gnu.org/licenses/gpl-2.0.html  GNU General Public License, version 2
 * @version   SVN: $Id$
 * @link      http://wordpress.org/extend/plugins/user-access-manager/
 */

// return;

// --- Error Messages ---
define('TXT_UAM_PHP_VERSION_TO_LOW',  'Sorry you need at least PHP version 7.2 to use the User Access Manager. Your current PHP version is %s. See <a href="https://github.com/GM-Alex/user-access-manager/wiki/Troubleshoot">https://github.com/GM-Alex/user-access-manager/wiki/Troubleshoot</a> for more information.');
define('TXT_UAM_WORDPRESS_VERSION_TO_LOW',  'Sorry you need at least WordPress version 3.0 to use the User Access Manager. Your current WordPress version is %s.');
/** @noinspection HtmlUnknownTarget */
define('TXT_UAM_NEED_DATABASE_UPDATE',  'Please update the database of the User Access Manager. <a href="%s">Click here to proceed</a>');
define('TXT_UAM_ERROR',  'The following error occurred: %s');

// --- Multiple use ---
define('TXT_UAM_ALL',  'All');
define('TXT_UAM_ALL_USERS',  'All users (group and none group users)');
define('TXT_UAM_ONLY_GROUP_USERS',  'Only group users');
define('TXT_UAM_NONE',  'None');
define('TXT_UAM_YES',  'Yes');
define('TXT_UAM_NO',  'No');


// --- Setting Page ---
define('TXT_UAM_SETTINGS',  'Settings');
define('TXT_UAM_SETTINGS_GROUP_SECTION_DEFAULT',  'Default');

// --- Setting Page -> object settings ---
define('TXT_UAM_POST_TYPES_SECTION_SELECTION_SETTING',  'Object type');
define('TXT_UAM_POST_TYPES_SETTING',  'Post type settings');
define('TXT_UAM_TAXONOMIES_SETTING',  'Taxonomies settings');
define('TXT_UAM_DEFAULT_SETTING',  'Default settings');
define('TXT_UAM_DEFAULT_SETTING_DESC',  'Set up the behaviour if the object is locked');
define('TXT_UAM_DEFAULT_TITLE',  'Title');
define('TXT_UAM_DEFAULT_TITLE_DESC',  'Displayed text as title if user has no access');
define('TXT_UAM_HIDE_DEFAULT_TITLE',  'Hide title');
define('TXT_UAM_HIDE_DEFAULT_TITLE_DESC',  'Selecting "Yes" will show the text which is defined at "Title" if user has no access.');
define('TXT_UAM_DEFAULT_CONTENT',  'Content');
define('TXT_UAM_DEFAULT_CONTENT_DESC',  'Content displayed if user has no access. You can add a login-form by adding the keyword <strong>[LOGIN_FORM]</strong>. This form will be shown on single %s, otherwise a link will be shown.');
define('TXT_UAM_HIDE_DEFAULT',  'Hide complete');
define('TXT_UAM_HIDE_DEFAULT_DESC',  'Selecting "Yes" will hide %s if the user has no access.');
define('TXT_UAM_DEFAULT_COMMENT_CONTENT',  'Comment text');
define('TXT_UAM_DEFAULT_COMMENT_CONTENT_DESC',  'Displayed text as comment text if user has no access');
define('TXT_UAM_HIDE_DEFAULT_COMMENT',  'Hide comments');
define('TXT_UAM_HIDE_DEFAULT_COMMENT_DESC',  'Selecting "Yes" will show the text which is defined at "%s comment text" if user has no access.');
define('TXT_UAM_DEFAULT_COMMENTS_LOCKED',  'Lock comments');
define('TXT_UAM_DEFAULT_COMMENTS_LOCKED_DESC',  'Selecting "yes" allows users to comment even if the content is locked');
define('TXT_UAM_SHOW_DEFAULT_CONTENT_BEFORE_MORE',  'Show content before &lt;!--more--&gt; tag');
// define('TXT_UAM_SHOW_DEFAULT_CONTENT_BEFORE_MORE_DESC',  'Shows the content before the &lt;!--more--&gt; tag and after that the defined text at "%s content". If no &lt;!--more--&gt; is set the defined text at "%s content" will be shown.'); //TODO

define('TXT_UAM_SHOW_DEFAULT_CONTENT_BEFORE_MORE_DESC', 'Shows the content before the &lt;!--more--&gt; tag and after that the defined text at "%s content". If no &lt;!--more--&gt; is set the defined text at "%s content" will be shown.'); //TODO

define('TXT_UAM_OBJECT_USE_DEFAULT',  'Use default settings for %s');
define('TXT_UAM_OBJECT_USE_DEFAULT_DESC',  'If selected the settings form the default type will be used.');
define('TXT_UAM_OBJECT_SETTING',  '%s settings');
define('TXT_UAM_OBJECT_SETTING_DESC',  'Set up the behaviour if the %s is locked');
define('TXT_UAM_OBJECT_TITLE',  '%s title');
define('TXT_UAM_OBJECT_TITLE_DESC',  'Displayed text as %s title if user has no access');
define('TXT_UAM_HIDE_OBJECT_TITLE',  'Hide %s title');
define('TXT_UAM_HIDE_OBJECT_TITLE_DESC',  'Selecting "Yes" will show the text which is defined at "%s title" if user has no access.');
define('TXT_UAM_OBJECT_CONTENT',  '%s content');
define('TXT_UAM_OBJECT_CONTENT_DESC',  'Content displayed if user has no access. You can add a login-form by adding the keyword <strong>[LOGIN_FORM]</strong>. This form will be shown on single %s, otherwise a link will be shown.');
define('TXT_UAM_HIDE_OBJECT',  'Hide complete %s');
define('TXT_UAM_HIDE_OBJECT_DESC',  'Selecting "Yes" will hide %s if the user has no access.');
define('TXT_UAM_OBJECT_COMMENT_CONTENT',  '%s comment text');
define('TXT_UAM_OBJECT_COMMENT_CONTENT_DESC',  'Displayed text as %s comment text if user has no access');
define('TXT_UAM_HIDE_OBJECT_COMMENT',  'Hide %s comments');
define('TXT_UAM_HIDE_OBJECT_COMMENT_DESC',  'Selecting "Yes" will show the text which is defined at "%s comment text" if user has no access.');
define('TXT_UAM_OBJECT_COMMENTS_LOCKED',  'Lock %s comments');
define('TXT_UAM_OBJECT_COMMENTS_LOCKED_DESC',  'Selecting "yes" also locks comments on locked %s');
define('TXT_UAM_SHOW_OBJECT_CONTENT_BEFORE_MORE',  'Show %s content before &lt;!--more--&gt; tag');
// define('TXT_UAM_SHOW_OBJECT_CONTENT_BEFORE_MORE_DESC',  'Shows the %s content before the &lt;!--more--&gt; tag and after that the defined text at "%s content". If no &lt;!--more--&gt; is set the defined text at "%s content" will shown.'); //TODO

define('TXT_UAM_SHOW_OBJECT_CONTENT_BEFORE_MORE_DESC', 'Shows the %s content before the &lt;!--more--&gt; tag and after that the defined text at "%s content". If no &lt;!--more--&gt; is set the defined text at "%s content" will shown.'); //TODO

// --- Setting Page -> file settings ---
define('TXT_UAM_FILE_SETTING',  'File settings');
define('TXT_UAM_FILE_SETTING_DESC',  'Set up the behaviour of files');
define('TXT_UAM_LOCK_FILE',  'Lock files');
define('TXT_UAM_NO_ACCESS_IMAGE_TYPE',  'No access image type');
define('TXT_UAM_NO_ACCESS_IMAGE_TYPE_DESC',  'If you choose "Custom", please specify the full path to your image.');
define('TXT_UAM_NO_ACCESS_IMAGE_TYPE_DEFAULT',  'Default');
define('TXT_UAM_NO_ACCESS_IMAGE_TYPE_CUSTOM',  'Custom');
define('TXT_UAM_USE_CUSTOM_FILE_HANDLING_FILE',  'Use custom file handling file');
define('TXT_UAM_USE_CUSTOM_FILE_HANDLING_FILE_DESC',  'Selecting "Yes" will allow you to use your own config file.');
define('TXT_UAM_CUSTOM_FILE_HANDLING_FILE',  'Custom file handling file');
define('TXT_UAM_CUSTOM_FILE_HANDLING_FILE_DESC',  'Edit this content if you are using the custom file handling file setting.');
define('TXT_UAM_LOCK_FILE_DESC',  'If you select "Yes" all files will locked by a .htaccess file and only users with access can download files. <br/><strong style="color:red;">Note: If you activate this option the plugin will overwrite a \'.htaccess\' file at the upload folder, if you use already one to protect your files. Also if you have no permalinks activated your upload dir will protect by a \'.htaccess\' with a random password and all old media files insert in a previous post/page will not work anymore. You have to update your posts/pages (not necessary if you have permalinks activated).</strong>');
define('TXT_UAM_LOCKED_DIRECTORY_TYPE',  'Locked directory type');
define('TXT_UAM_LOCKED_DIRECTORY_TYPE_DESC',  '"WordPress" will only lock files handled by the WordPress media manager (recommended), "All" will lock all files at the upload directory, "Custom" will use a custom string.');
define('TXT_UAM_LOCKED_DIRECTORY_TYPE_WORDPRESS',  'WordPress');
define('TXT_UAM_LOCKED_DIRECTORY_TYPE_ALL',  'All');
define('TXT_UAM_LOCKED_DIRECTORY_TYPE_CUSTOM',  'Custom');
define('TXT_UAM_LOCK_FILE_TYPES',  'Locked file types');
define('TXT_UAM_LOCK_FILE_TYPES_DESC',  'Lock all files, type in file types which you will lock if the post/page is locked or define file types which will not be locked. <strong>Note:</strong> If you have no problems use all to get the maximum security.');
define('TXT_UAM_LOCK_FILE_TYPES_ALL',  'All');
define('TXT_UAM_LOCK_FILE_TYPES_SELECTED',  'File types to lock: ');
define('TXT_UAM_LOCK_FILE_TYPES_NOT_SELECTED',  'File types not to lock: ');
define('TXT_UAM_FILE_PASS_TYPE',  '.htaccess password');
define('TXT_UAM_FILE_PASS_TYPE_DESC',  'Set up the password for the .htaccess access. This password is only needed if you need a direct access to your files.');
define('TXT_UAM_FILE_PASS_TYPE_RANDOM',  'Use a random generated password.');
define('TXT_UAM_FILE_PASS_TYPE_USER',  'Use the password of the current logged in admin.');
define('TXT_UAM_DOWNLOAD_TYPE',  'Download type');
define('TXT_UAM_DOWNLOAD_TYPE_DESC',  'Selecting the type for downloading. <strong>Note:</strong> For using fopen you need "safe_mode = off".');
define('TXT_UAM_INLINE_FILES',  'Inline file types');
define('TXT_UAM_INLINE_FILES_DESC',  'These files (comma separated) will be shown within the browser window and not downloaded (images are always inline).');
define('TXT_UAM_DOWNLOAD_TYPE_NORMAL',  'Normal');
define('TXT_UAM_DOWNLOAD_TYPE_FOPEN',  'fopen');
define('TXT_UAM_DOWNLOAD_TYPE_XSENDFILE',  'XSendfile');

// --- Setting Page -> editor settings ---
define('TXT_UAM_AUTHOR_SETTING',  'Authors settings');
define('TXT_UAM_AUTHOR_SETTING_DESC',  'Here you will find the settings for authors');
define('TXT_UAM_AUTHORS_HAS_ACCESS_TO_OWN',  'Authors always has access to own posts/pages');
define('TXT_UAM_AUTHORS_HAS_ACCESS_TO_OWN_DESC',  'If "Yes" is selected author will always have full access to their own posts or pages.');
define('TXT_UAM_AUTHORS_CAN_ADD_POSTS_TO_GROUPS',  'Authors can add content to their own groups');
define('TXT_UAM_AUTHORS_CAN_ADD_POSTS_TO_GROUPS_DESC',  'If "Yes" is selected author are able to restrict the content by adding it to their groups.');
define('TXT_UAM_FULL_ACCESS_ROLE',  'Minimum user role with full access');
define('TXT_UAM_FULL_ACCESS_ROLE_DESC',  'All user with a role equal or higher to this has full access.');
define('TXT_UAM_FULL_ACCESS_ROLE_ADMINISTRATOR',  'Administrator');
define('TXT_UAM_FULL_ACCESS_ROLE_EDITOR',  'Editor');
define('TXT_UAM_FULL_ACCESS_ROLE_AUTHOR',  'Author');
define('TXT_UAM_FULL_ACCESS_ROLE_CONTRIBUTOR',  'Contributor');
define('TXT_UAM_FULL_ACCESS_ROLE_SUBSCRIBER',  'Subscriber');

// --- Settings Page -> taxonomies ---
define('TXT_UAM_TAXONOMIES_SECTION_SELECTION_SETTING',  'Object type');
define('TXT_UAM_TAXONOMY_SETTING',  'Taxonomy settings');
define('TXT_UAM_TAXONOMY_SETTING_DESC',  'Set up the behaviour if a taxonomy is locked');
define('TXT_UAM_HIDE_EMPTY_DEFAULT',  'Hide empty');
define('TXT_UAM_HIDE_EMPTY_DEFAULT_DESC',  'Selecting "Yes" will hide empty taxonomies which are containing only empty childes or no childes.');
define('TXT_UAM_HIDE_EMPTY_OBJECT',  'Hide empty %s');
define('TXT_UAM_HIDE_EMPTY_OBJECT_DESC',  'Selecting "Yes" will hide empty %s which are containing only empty childes or no childes.');

// --- Settings Page -> cache ---
define('TXT_UAM_CACHE_SECTION_SELECTION_SETTING',  'Active caching method');
define('TXT_UAM_CACHE_SETTING',  'Cache settings');
define('TXT_UAM_NONE_SETTING',  'Cache deactivated');
define('TXT_UAM_NONE_SETTING_DESC',  'The cache is currently deactivated.');
define('TXT_UAM_FILESYSTEMCACHEPROVIDER_SETTING',  'File system cache');
define('TXT_UAM_FILESYSTEMCACHEPROVIDER_SETTING_DESC',  'This cache uses the file system for the cache.');
define('TXT_UAM_FS_CACHE_PATH',  'Path');
define('TXT_UAM_FS_CACHE_PATH_DESC',  'File system path to store the cache files.');
define('TXT_UAM_FS_CACHE_METHOD',  'Method');
define('TXT_UAM_FS_CACHE_METHOD_DESC',  'The caching method which should be used.');
define('TXT_UAM_FS_CACHE_METHOD_SERIALIZE',  'PHP serialize');
define('TXT_UAM_FS_CACHE_METHOD_IGBINARY',  'PHP igbinary (igbinary required)');
define('TXT_UAM_FS_CACHE_METHOD_JSON',  'Json');
define('TXT_UAM_FS_CACHE_METHOD_VAR_EXPORT',  'PHP var_export');

// --- Setting Page -> other settings ---
define('TXT_UAM_OTHER_SETTING',  'Other settings');
define('TXT_UAM_OTHER_SETTING_DESC',  'Here you will find all other settings');
define('TXT_UAM_PROTECT_FEED',  'Protect Feed');
define('TXT_UAM_PROTECT_FEED_DESC',  'Selecting "Yes" will also protect your feed entries.');
define('TXT_UAM_REDIRECT',  'Redirect user');
define('TXT_UAM_REDIRECT_DESC',  'Setup what happen if a user visit a post/page with no access.');
define('TXT_UAM_REDIRECT_TO_BLOG',  'To blog start page');
define('TXT_UAM_REDIRECT_TO_LOGIN',  'To login page (wp-admin)');
define('TXT_UAM_REDIRECT_TO_PAGE',  'Custom page: ');
define('TXT_UAM_REDIRECT_TO_URL',  'Custom URL: ');
define('TXT_UAM_LOCK_RECURSIVE',  'Lock recursive');
define('TXT_UAM_LOCK_RECURSIVE_DESC',  'Selecting "Yes" will lock all child posts/pages of a post/page if a user has no access to the parent page. Note: Setting this option to "No" could result in display errors relating to the hierarchy.');
define('TXT_UAM_BLOG_ADMIN_HINT_TEXT',  'Admin hint text');
define('TXT_UAM_BLOG_ADMIN_HINT_TEXT_DESC',  'The text which will shown behind the post/page.');
define('TXT_UAM_BLOG_ADMIN_HINT',  'Show admin hint at Posts');
define('TXT_UAM_BLOG_ADMIN_HINT_DESC', 'Selecting "Yes" will show the defined text at "%s" behind the post/page to a logged in admin to show him which posts/pages are locked if he visits his blog.');
define('TXT_UAM_SHOW_ASSIGNED_GROUPS',  'Show assigned groups');
define('TXT_UAM_SHOW_ASSIGNED_GROUPS_DESC',  'Show assigned groups next to the edit link');
define('TXT_UAM_HIDE_EDIT_LINK_ON_NO_ACCESS',  'Hide edit link on no access');
define('TXT_UAM_HIDE_EDIT_LINK_ON_NO_ACCESS_DESC',  'Hides the edit link if the user has no write access.');
define('TXT_UAM_EXTRA_IP_HEADER',  'Extra IP header');
define('TXT_UAM_EXTRA_IP_HEADER_DESC',  'Use this header for the user IP address if you are using a proxy. A valid value is for example HTTP_X_REAL_IP.');

// --- Setting Page -> default values ---
define('TXT_UAM_SETTING_DEFAULT_NO_RIGHTS',  'No rights!');
define('TXT_UAM_SETTING_DEFAULT_NO_RIGHTS_FOR_ENTRY',  'Sorry you have no rights to view this entry!');
define('TXT_UAM_SETTING_DEFAULT_NO_RIGHTS_FOR_COMMENTS',  'Sorry no rights to view comments!');

// --- Setting Page -> update message ---
define('TXT_UAM_UPDATE_SETTING',  'Update settings');
define('TXT_UAM_UPDATE_SETTINGS',  'Settings updated.');


// --- User groups page ---
define('TXT_UAM_MANAGE_GROUP',  'Manage user groups');
define('TXT_UAM_USER_GROUPS_SETTING',  'User groups');
define('TXT_UAM_GROUP_ROLE',  'Role affiliation');
define('TXT_UAM_NAME',  'Name');
define('TXT_UAM_DESCRIPTION',  'Description');
define('TXT_UAM_READ_ACCESS',  'Read access');
define('TXT_UAM_WRITE_ACCESS',  'Write access');
define('TXT_UAM_DELETE',  'Delete');
define('TXT_UAM_UPDATE_GROUP',  'Update group');
define('TXT_UAM_ADD',  'Add');
define('TXT_UAM_ADD_GROUP',  'Add user group');
define('TXT_UAM_EDIT_GROUP',  'Edit user group');
define('TXT_UAM_GROUP_NAME',  'User group name');
define('TXT_UAM_GROUP_NAME_DESC',  'The name is used to identify the access user group.');
define('TXT_UAM_GROUP_DESC',  'User group description');
define('TXT_UAM_GROUP_DESC_DESC',  'The description of the group.');
define('TXT_UAM_GROUP_IP_RANGE',  'IP range');
define('TXT_UAM_GROUP_IP_RANGE_DESC',  'Type in the IP ranges of users which are join these groups by their IP address without login. Set ranges like "BEGIN"-"END", separate ranges by using ";", single IPs are also allowed. Example: 192.168.0.1-192.168.0.10;192.168.0.20-192.168.0.30');
define('TXT_UAM_GROUP_READ_ACCESS',  'Read access');
define('TXT_UAM_GROUP_READ_ACCESS_DESC',  'The read access.');
define('TXT_UAM_GROUP_WRITE_ACCESS',  'Write access');
define('TXT_UAM_GROUP_WRITE_ACCESS_DESC',  'The write access.');
define('TXT_UAM_GROUP_ADDED',  'Group was added successfully.');
define('TXT_UAM_GROUP_NAME_ERROR',  'Group name can not be empty.');
define('TXT_UAM_DELETE_GROUP',  'Group(s) was deleted successfully.');
define('TXT_UAM_USER_GROUP_EDIT_SUCCESS',  'User group edit successfully.');
define('TXT_UAM_IP_RANGE',  'IP range');
define('TXT_UAM_DEFAULT_USER_GROUPS_SETTING',  'Default user groups');
define('TXT_UAM_DEFAULT_USER_GROUPS_SECTION_SELECTION_SETTING',  'Default user groups for object type');
define('TXT_UAM_UPDATE_DEFAULT_USER_GROUPS',  'Update default user groups');
define('TXT_UAM_SET_DEFAULT_USER_GROUP_SUCCESS',  'Default user groups updated');
define('TXT_UAM_POST_TYPE',  'Post Type');
define('TXT_UAM_TAXONOMY_TYPE',  'Taxonomy');


// --- Setup page ---
define('TXT_UAM_SETUP',  'Setup');
define('TXT_UAM_SETUP_DANGER_ZONE',  'Danger Zone');
define('TXT_UAM_RESET_UAM',  'Reset User Access Manager');
define('TXT_UAM_RESET_UAM_DESCRIPTION',  'Type \'reset\' in the input field to reset the User Access Manager.');
define('TXT_UAM_RESET_UAM_DESC_WARNING',  'Warning: The reset of the User Access Manager can not be undone. All settings and user groups will permanently lost.');
define('TXT_UAM_RESET',  'reset now');
define('TXT_UAM_UPDATE_UAM_DB',  'Update User Access Manager database');
define('TXT_UAM_UPDATE_UAM_DB_DESCRIPTION',  'Updates the database of the User Access Manager. Please backup your database before you perform the update.');
define('TXT_UAM_UPDATE',  'update now');
define('TXT_UAM_UAM_RESET_SUCCESS',  'User Access Manager was reset successfully');
define('TXT_UAM_UAM_DB_UPDATE_SUCCESS',  'User Access Manager database was updated successfully');
define('TXT_UAM_UAM_DB_UPDATE_FAILURE',  'Failure on User Access Manager database update');
define('TXT_UAM_UPDATE_BLOG',  'Update current blog');
define('TXT_UAM_UPDATE_NETWORK',  'Update network wide');
define('TXT_UAM_UPDATE_BACKUP',  'Backup the uam database tables');
define('TXT_UAM_REPAIR_DATABASE',  'Repair the database');
define('TXT_UAM_REPAIR_DATABASE_DESCRIPTION',  'Try to repair the database.');
define('TXT_UAM_REPAIR_DATABASE_REPAIR_NOW',  'repair now');
define('TXT_UAM_REPAIR_DATABASE_SUCCESS',  'Database repair successfull');
define('TXT_UAM_DATABASE_BROKEN',  '<b style="color:red;">Your UAM database seems broken. You should try to repair it.</b>');
define('TXT_UAM_DATABASE_OK',  '<b style="color:green;">Your UAM database seems to be in good condition.</b>');
define('TXT_UAM_REVERT_DATABASE',  'Revert the database');
define('TXT_UAM_REVERT_DATABASE_DESCRIPTION',  'Choose a backup to revert the database to this user access manager database version. <b>Note: The user access manager database version differs from the user access manager version.</b>');
define('TXT_UAM_REVERT_DATABASE_REVERT_NOW',  'revert now');
define('TXT_UAM_REVERT_DATABASE_SUCCESS',  'Revert successfull');
define('TXT_UAM_DELETE_DATABASE_BACKUP',  'Delete a database backup');
define('TXT_UAM_DELETE_DATABASE_BACKUP_DESCRIPTION',  'Choose a backup to delete. <b>Note: That cannot be undone.</b>');
define('TXT_UAM_DELETE_DATABASE_BACKUP_DELETE_NOW',  'delete now');
define('TXT_UAM_DELETE_DATABASE_BACKUP_SUCCESS',  'Backup deleted successfully');


// --- About page ---
define('TXT_UAM_ABOUT',  'About');

// --- About page -> support ---
define('TXT_UAM_HOW_TO_SUPPORT',  'How to support me?');
define('TXT_UAM_SEND_REPORTS_HEAD',  'Help me to improve the plugin');
define('TXT_UAM_SEND_REPORTS',  'Send me bug reports, bug fixes, pull requests or your ideas. See: <a href="https://github.com/GM-Alex/user-access-manager">https://github.com/GM-Alex/user-access-manager</a>');
define('TXT_UAM_CREATE_TRANSLATION_HEAD',  'Create a translation of the plugin');
define('TXT_UAM_CREATE_TRANSLATION',  'Give other users more comfort help me to translate it to all languages. See: <a href="https://translate.wordpress.org/projects/wp-plugins/user-access-manager">https://translate.wordpress.org/projects/wp-plugins/user-access-manager</a>');
define('TXT_UAM_DONATE_HEAD',  'Donate via PayPal');
define('TXT_UAM_SUPPORT_ME_ON_STEADY_HEAD',  'Support me on Steady');
define('TXT_UAM_SPREAD_THE_WORD_HEAD',  'Spread the word');
define('TXT_UAM_SPREAD_THE_WORD',  'Write about the plugin and place a link to the plugin in your blog/website.');

// --- About page -> thanks ---
define('TXT_UAM_THANKS',  'Thanks');
define('TXT_UAM_STEADY_BE_THE_FIRST',  'Be the first one supporting me on steady!');
define('TXT_UAM_TOP_SUPPORTERS',  'Top supporters');
define('TXT_UAM_SUPPORTERS',  'Supporters');
define('TXT_UAM_SPECIAL_THANKS',  'Special thanks');
define('TXT_UAM_SPECIAL_THANKS_FIRST',  'My wife for giving me the time to develop this plugin');
define('TXT_UAM_SPECIAL_THANKS_LAST',  'All testers and all others I forgot');


// --- Columns ---
define('TXT_UAM_COLUMN_ACCESS',  'Access');
define('TXT_UAM_COLUMN_USER_GROUPS',  'UAM User Groups');


// --- Edit forms ---
define('TXT_UAM_FULL_ACCESS',  'Full access');
define('TXT_UAM_MEMBER_OF_OTHER_GROUPS',  'Member of %s other user groups');
define('TXT_UAM_ADMIN_HINT',  '<strong>Note:</strong> An administrator has always access to all posts/pages.');
define('TXT_UAM_CREATE_GROUP_FIRST',  'Please create a user group first.');
define('TXT_UAM_NO_GROUP_AVAILABLE',  'No user group available.');
define('TXT_UAM_NO_RIGHTS_TITLE',  'No rights');
define('TXT_UAM_NO_RIGHTS_MESSAGE',  'You have no rights to access this content.');
define('TXT_UAM_GROUPS',  'User Groups');
define('TXT_UAM_SET_UP_USER_GROUPS',  'Set up user groups');
define('TXT_UAM_NONCE_FAILURE_TITLE',  'Nonce error');
define('TXT_UAM_NONCE_FAILURE_MESSAGE',  'Sorry, your nonce did not verify.');

// --- Group info ---
define('TXT_UAM_INFO',  'Info');
define('TXT_UAM_GROUP_INFO',  'Group info');
define('TXT_UAM_GROUP_MEMBERSHIP_BY',  'Group membership given by %s');
define('TXT_UAM_ASSIGNED_GROUPS',  'Assigned groups');
define('TXT_UAM_GROUP_TYPE__ROLE_',  'Role');
define('TXT_UAM_GROUP_TYPE__USER_',  'User');
define('TXT_UAM_GROUP_TYPE__TERM_',  'Term');
define('TXT_UAM_GROUP_TYPE__POST_',  'Post');


// --- File access ---
define('TXT_UAM_FILE_INFO_DB_ERROR',  'Opening file info database failed.');
define('TXT_UAM_FILE_NOT_FOUND_ERROR_TITLE',  'Error: File not found.');
define('TXT_UAM_FILE_NOT_FOUND_ERROR_MESSAGE',  'The file you are looking for wasn\'t found.');


// --- Login form ---
define('TXT_UAM_LOGIN_FORM_USERNAME',  'Username');
define('TXT_UAM_LOGIN_FORM_PASSWORD',  'Password');
define('TXT_UAM_LOGIN_FORM_LOGIN',  'Login');
define('TXT_UAM_LOGIN_FORM_LOGOUT',  'Logout');
define('TXT_UAM_LOGIN_FORM_WELCOME_MESSAGE',  'Welcome, %s!');
define('TXT_UAM_LOGIN_FORM_REGISTER',  'Register');
define('TXT_UAM_LOGIN_FORM_LOST_PASSWORD',  'Lost your password?');
define('TXT_UAM_LOGIN_FORM_LOST_AND_FOUND_PASSWORD',  'Password Lost and Found');
define('TXT_UAM_LOGIN_FORM_REMEMBER_ME',  'Remember me');


// --- User group ---
define('TXT_UAM_GROUP_ASSIGNMENT_TIME',  'Setup time based group assignment');
define('TXT_UAM_GROUP_FROM_DATE',  'From');
define('TXT_UAM_GROUP_TO_DATE',  'To');
define('TXT_UAM_GROUP_FROM_TIME',  'From');
define('TXT_UAM_GROUP_TO_TIME',  'To');


// --- Dynamic user groups ---
define('TXT_UAM_USER',  'User');
define('TXT_UAM_ROLE',  'Role');
define('TXT_UAM_ADD_DYNAMIC_NOT_LOGGED_IN_USERS',  'Not logged in users');
define('TXT_UAM_ADD_DYNAMIC_GROUP',  'Add dynamic groups');

// --- Login widget ---
define('TXT_UAM_LOGIN_WIDGET_TITLE',  'UAM login widget');
define('TXT_UAM_LOGIN_WIDGET_DESC',  'User Access Manager login widget for users.');

// --- Info bar ---
define('TXT_UAM_INFO_BOX_UAM_PRO_HEAD',  'Get User Access Manager Pro!');
define('TXT_UAM_INFO_BOX_UAM_PRO_CONTENT',  'You want all the features? Guess what? You are already using the Pro version, because there is none. So it would be nice if you support me and become a supporter at steady, <b>especially if you use the plugin on a commercial site</b>. This will keep me motivated to do the support and spend my free time for the plugin. ;)');
define('TXT_UAM_INFO_BOX_DOCUMENTATION_HEAD',  'Need help?');
define('TXT_UAM_INFO_BOX_DOCUMENTATION_CONTENT',  'You got stuck using the User access manager? See <a href="https://github.com/GM-Alex/user-access-manager/wiki">https://github.com/GM-Alex/user-access-manager/wiki</a>');

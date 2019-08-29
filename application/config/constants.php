<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| FACEBOOK AND TWITTER
|--------------------------------------------------------------------------
|
*/
define('FACEBOOK_APP_ID', '');
define('FACEBOOK_SECRET', '');
define('TWITTER_CONSUMER_KEY', '');
define('TWITTER_CONSUMER_SECRET', '');

/*
|--------------------------------------------------------------------------
| FORM DELIMITERS
|--------------------------------------------------------------------------
|
*/

define('FORM_LABEL_OPEN',							'<div class="form_label_delimiter" align="left">');
define('FORM_LABEL_CLOSE',							'</div>');
define('ERROR_DELIMITER_OPEN',							'<div class="help-inline form_error_delimiter" align="left">');
define('ERROR_DELIMITER_CLOSE',							'</div>');

/*
|--------------------------------------------------------------------------
| LABELS
|--------------------------------------------------------------------------
|
*/

define('SITE_NAME',		'propertyfinder.com');
define('PAGE_TITLE',		' - propertyfinder.com');

/*
|--------------------------------------------------------------------------
| CACHING
|--------------------------------------------------------------------------
|
*/

define('CACHE_COMMON',  		'common');
define('CACHE_COMMON_TIME',  		'2592000'); //30days
define('CACHE_USER_TIME',  		'600'); //10mins

/*
|--------------------------------------------------------------------------
| RECORD CODES' PREFIXES
|--------------------------------------------------------------------------
|
*/

define('CODE_PROPERTY',  		'P');
define('CODE_AGENT',                    'A');
define('CODE_COMPANY',  		'C');

/*
|--------------------------------------------------------------------------
| PROPERTY'S DEFAULT PROFILE MAXIMUM IMAGE DIMENSIONS
|--------------------------------------------------------------------------
|
*/

define('PROPPROFILEPIC_MAXWIDTH',  		'320'); //'432'
define('PROPPROFILEPIC_MAXHEIGHT', 		'240'); //'300'

/*
|--------------------------------------------------------------------------
| SEARCH LIMITS
|--------------------------------------------------------------------------
|
*/

define('LIMIT_POPULAR', 		'10');
define('LIMIT_NEWEST',                  '10');
define('LIMIT_HOME',    		'20');
define('LIMIT_PROPERTIES',		'10');
define('LIMIT_AGENTS',                  '10');
define('LIMIT_COMPANIES',               '10');
define('LIMIT_MYPROPERTIES',		'10');
define('LIMIT_AGENTPROPERTIES',		'10');
define('LIMIT_MYSHORTLIST',		'10');
define('LIMIT_MYRECENTVIEWS',           '10');
define('LIMIT_COMPANYPROPERTIES',       '10');
define('LIMIT_COMPANYAGENTS',           '10');
define('LIMIT_MAP',                     '100');

/*
|--------------------------------------------------------------------------
| LIST LIMITS PER USER
|--------------------------------------------------------------------------
|
*/

define('LIMIT_SHORTLIST', 		'10');
define('LIMIT_SHORTLIST_NOTSIGNEDIN',	'2');
define('LIMIT_RECENTVIEWS',             '2');
define('LIMIT_RECENTVIEWS_NOTSIGNEDIN', '2');
define('LIMIT_COMPARE',                 '5');
define('LIMIT_COMPARE_NOTSIGNEDIN',     '2');

/*
|--------------------------------------------------------------------------
| USER PROFILE LEVELS
|--------------------------------------------------------------------------
|
*/

define('LEVEL_NEWBIE',		'N');
define('LEVEL_REGULAR',		'R');
define('LEVEL_MASTER',		'M');
define('LEVEL_PRIME',		'P');
define('LEVEL_MODERATOR',	'1');

/*
|--------------------------------------------------------------------------
| PROPERTY POSTING
|--------------------------------------------------------------------------
|
*/

define('PROPPOST_RENT',         'R');
define('PROPPOST_SALE',         'S');
define('PROPPOST_OWN',          'O');

/*
|--------------------------------------------------------------------------
| PROPERTY FINANCING
|--------------------------------------------------------------------------
|
*/

define('PROPFINANCING_CASH',         'C');
define('PROPFINANCING_BANK',         'B');
define('PROPFINANCING_PAGIBIG',      'P');

/*
|--------------------------------------------------------------------------
| PROPERTY CATEGORIES
|--------------------------------------------------------------------------
|
*/

define('PROPCATEGORY_RESIDENTIAL',	'R');
define('PROPCATEGORY_COMMERCIAL',	'C');
define('PROPCATEGORY_LAND',		'L');
define('PROPCATEGORY_HOTEL',		'H');

/*
|--------------------------------------------------------------------------
| PROPERTY SUB-CATEGORIES
|--------------------------------------------------------------------------
|
*/

define('PROPSUBCATEGORY_R_CONDOMINIUM',         'RC');
define('PROPSUBCATEGORY_R_HOUSEANDLOT',         'RHL');
define('PROPSUBCATEGORY_R_APARTMENT',           'RA');
define('PROPSUBCATEGORY_R_HDB',                 'RH');
define('PROPSUBCATEGORY_R_BOARDINGHOUSE',	'RBH');
define('PROPSUBCATEGORY_C_OFFICE',              'CO');
define('PROPSUBCATEGORY_C_SOHO',                'CSH');
define('PROPSUBCATEGORY_C_RETAIL',              'CR');
define('PROPSUBCATEGORY_C_INDUSTRIAL',          'CI');
define('PROPSUBCATEGORY_L_LANDONLY',            'LLO');
define('PROPSUBCATEGORY_L_LANDWITHSTRUCTURE',	'LLS');
define('PROPSUBCATEGORY_L_FARM',                'LF');
define('PROPSUBCATEGORY_L_BEACH',               'LB');
define('PROPSUBCATEGORY_H_HOTELRESORT',         'HHR');
define('PROPSUBCATEGORY_H_PENSIONINN',          'HPI');
define('PROPSUBCATEGORY_H_CONVENTIONCENTER',	'HCC');

/*
|--------------------------------------------------------------------------
| PROPERTY CLASSIFICATIONS
|--------------------------------------------------------------------------
|
*/

define('PROPCLASS_R_CONDOMINIUM',       'RC');
define('PROPCLASS_R_CONDOMINIUMHOTEL',  'RCH');

define('PROPCLASS_R_PENTHOUSE',         'RP');
define('PROPCLASS_R_DETACHEDSINGLE',    'RDS');
define('PROPCLASS_R_DETACHEDMULTI',     'RDM');
define('PROPCLASS_R_DUPLEX',            'RDX');
define('PROPCLASS_R_TOWNHOUSE',         'RTH');
define('PROPCLASS_R_MANSIONETTE',       'RMT');
define('PROPCLASS_R_MANSION',           'RMN');

define('PROPCLASS_R_APARTMENT',         'RA');
define('PROPCLASS_R_BACHELORSPAD',      'RBP');
define('PROPCLASS_R_ROOM',              'RR');
define('PROPCLASS_R_BED',               'RB');
define('PROPCLASS_R_HDB',               'RH');
define('PROPCLASS_C_OFFICE',            'CO');
define('PROPCLASS_C_BUSINESSPARK',      'CBP');
define('PROPCLASS_C_SOHO',              'CSH');
define('PROPCLASS_C_MALL',              'CM');
define('PROPCLASS_C_SHOP',              'CS');
define('PROPCLASS_C_OTHER',             'CO');
define('PROPCLASS_C_FACTORY',           'CF');
define('PROPCLASS_C_WAREHOUSE',         'CW');
define('PROPCLASS_L_LANDONLY',          'LLO');
define('PROPCLASS_L_LANDWITHSTRUCTURE', 'LLS');
define('PROPCLASS_L_FARM',              'LF');
define('PROPCLASS_L_BEACH',             'LB');
define('PROPCLASS_H_HOTEL',             'HH');
define('PROPCLASS_H_HOTELANDRESORT',    'HHR');
define('PROPCLASS_H_RESORT',            'HR');
define('PROPCLASS_H_BACKPACKER',        'HBP');
define('PROPCLASS_H_PENSIONINN',        'HPI');
define('PROPCLASS_H_CONVENTIONCENTER',  'HCC');

/*
|--------------------------------------------------------------------------
| TENURE
|--------------------------------------------------------------------------
|
*/

define('TENURE_FREEHOLD',		'F');
define('TENURE_LEASEHOLD',		'L');
define('TENURE_1YEAR',                  '1');
define('TENURE_2YEARS',                 '2');
define('TENURE_3UP',    		'3UP');
define('TENURE_FLEXIBLE',    		'FLX');
define('TENURE_SHORTTERM',    		'SHT');

/*
|--------------------------------------------------------------------------
| PROPERTY RECORD STATUS
|--------------------------------------------------------------------------
|
*/

define('PROPSTATUS_DRAFT',              'D');
define('PROPSTATUS_ACTIVE',             'A');
define('PROPSTATUS_INACTIVE',           'I');
define('PROPSTATUS_DELETED',            'X');

/*
|--------------------------------------------------------------------------
| USER RECORD STATUS
|--------------------------------------------------------------------------
|
*/

define('USERSTATUS_ACTIVE',              'A');
define('USERSTATUS_BLOCKED',             'B');
define('USERSTATUS_SPAM',                'S');
define('USERSTATUS_DELETED',             'X');

/*
|--------------------------------------------------------------------------
| USER TYPE
|--------------------------------------------------------------------------
|
*/

define('USERTYPE_REGULAR',               'R');
define('USERTYPE_AGENT',                 'A');
define('USERTYPE_BROKER',                'B');
define('USERTYPE_COMPANY',               'C');

/*
|--------------------------------------------------------------------------
| FORM LABELS
|--------------------------------------------------------------------------
|
*/

define('REQUIRED_INPUT',  '<span class="required">*</span>');

/*
|--------------------------------------------------------------------------
| USER RECORD STATUS
|--------------------------------------------------------------------------
|
*/

define('YES',              'Y');
define('NO',               'N');

/*
|--------------------------------------------------------------------------
| PAYMENT STATUS
|--------------------------------------------------------------------------
|
*/

define('PAYSTATUS_PAID',  		'P');
define('PAYSTATUS_UNPAID',  		'U');

/*
|--------------------------------------------------------------------------
| PAYMENT RECORD STATUS
|--------------------------------------------------------------------------
|
*/

define('PAYRECSTATUS_SUBMITTED',  		'0');
define('PAYRECSTATUS_INACTIVE',  		'I');
define('PAYRECSTATUS_ACTIVE',                   'A');
define('PAYRECSTATUS_SUSPENDED',  		'S');
define('PAYRECSTATUS_DELETED',  		'X');
define('PAYRECSTATUS_VERIFYING',                'V');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
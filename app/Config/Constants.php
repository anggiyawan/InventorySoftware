<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

define('COMPANY', "WAREHOUSE MANAGEMENT");
define('VERSION', "20221009");
define('ADDRESS', "20221009");
define('COPYRIGHT', "2022");
define('APIKEY', "587523cf3744696b59afabc43a58702b5f35f7c162a77233f899a1d040b6170d");

class AUTONUMBER {
  const SALES_ORDER_NUMBER	= "SALES_ORDER_NUMBER";
  const LOCATION_TRANSFER	= "LOCATION_TRANSFER";
  const PACKING_SLIP		= "PACKING_SLIP";
  const DELIVERY_ORDER		= "DELIVERY_ORDER";
  const ADJUSTMENT			= "ADJUSTMENT";
}

class USERS {
  const DELETES	= 0;
  const ACTIVE	= 1;
  const DISABLED	= 2;
}

class GROUPS {
  const DELETES	= 0;
  const ENABLED	= 1;
  const DISABLED	= 2;
}

class REPRESENTATIVES {
  const DELETES	= 0;
  const ENABLED	= 1;
  const DISABLED	= 2;
  
	public static function getAllConsts() {
		return (new ReflectionClass(get_class()))->getConstants();
	}
}

class CUSTOMERS {
  const DELETES		= 0;
  const ACTIVE		= 1;
  const DISABLED	= 2;
}

class PRODUCTS {
  const DELETES	= 0;
  const ACTIVE	= 1;
  const DISABLED	= 2;
}

class PRODUCTS_TYPE {
  const SERVICE		= 1;
  const MATERIAL	= 2;
  const GOODS		= 3;
  const WIP			= 4;
  const ASSETS		= 5;
  
	public static function getAllConsts() {
		return (new ReflectionClass(get_class()))->getConstants();
	}
}

class LOCATION {
  const DELETES	= 0;
  const ACTIVE	= 1;
  const DISABLED	= 2;
}

class UNIT {
  const PCS	= "Pcs";
  const KG	= "Kg";
  const BOX	= "Box";
  const LTR	= "ltr";
  const CM	= "cm";
  const M	= "m";
  
	public static function getAllConsts() {
        return (new ReflectionClass(get_class()))->getConstants();
    }
}

class CUSTOMER_TYPE {
  const BUSINESS	= 1;
  const INDIVIDUAL	= 2;
}

class CUSTOMER_ADDRESS_TYPE {
  const BILLING_ADDRESS		= 1;
  const SHIPPING_ADDRESS	= 2;
}

class CUSTOMER_ADDRESS_STATUS {
  const DELETES		= 0;
  const PRIMARY		= 1;
  const SECONDARY	= 2;
}

class APPROVAL {
  const SALES_ORDERS	= "SALES ORDERS";
  const DELIVERY_ORDERS	= "DELIVERY ORDERS";
}

class APPROVAL_STATUS {
  const APPROVED	= 1;
  const REJECTED	= 2;
}


class SALES_ORDER_STATUS {
  const DRAFT		= 1;
  // const APPROVAL	= 2;
  const CONFIRM		= 3;
  const PROGRESS	= 4;
  const SHIPMENT	= 5;
  const HOLD		= 8;
  const CLOSED		= 9;
  
	public static function getAllConsts() {
		return (new ReflectionClass(get_class()))->getConstants();
	}
}

class DELIVERY_ORDER_STATUS {
  const DRAFT		= 1;
  const CONFIRM		= 2;
  // const PROCESED	= 2;
  const DELIVERED	= 3;
  
	public static function getAllConsts() {
		return (new ReflectionClass(get_class()))->getConstants();
	}
}

class SALES_ORDER_AMOUNT {
  const SUBTOTAL	= "sub_total";
  const DISCON		= "discon";
  const SHIPPCHARGE	= "shipp_charge";
}

class SALES_ORDER_AMOUNT_TITLE {
  const SUBTOTAL	= "Sub Total";
  const DISCON		= "Discon";
  const SHIPPCHARGE	= "Shipping Charge";
}
<?php
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandUauiGetCookies")) {
    class commandUauiGetCookies extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            return $_COOKIE;
        }

        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Get server cookies content."), 
                "parameters" => array(), 
                "response" => array(
                    'cookies' => __('Cookies content'),
                ),
                "type" => array(
                    "parameters" => array(), 
                    "response" => array(
                        'cookies' => 'array',
                    ),
                ),
                "echo" => false
            );
        }
        
        public static function getAccess($ignore = "") {
            $me = __FILE__;
            return parent::getAccess($me);
        }
        
        public static function getAccessFlags() {
            return driverUser::PERMISSION_FILE_ALL_EXECUTE;
        }
        
//        public static function getAccessData($path = "") {
//            $me = __FILE__;
//            $resp = parent::getAccessData($me);
//            if ($resp["group"] == 0) {
//                $defGroup = 'useradmin';
//                $sql = "select `id` from `node_group` where `title` = '$defGroup'";
//                $q = dbConn::Execute($sql);
//                if (!$q->EOF) {
//                    $resp["group"] = $q->fields["id"];
//                }
//            }
//            return $resp;
//        }
    }
}
return new commandUauiGetCookies();
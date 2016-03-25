<?php
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandUauiInstall")) {
    class commandUauiInstall extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $path = driverCommand::getModPath('pharinix_mod_usergui');
            driverCommand::run('hooksAddPermanent', array(
                "hook" => "driverUserNewLogin",
                "file" => $path."drivers/uauiHandlers.php",
                "func" => "driverUauiHandlers::hookdriverUserNewLogin"
            ));
            driverCommand::run('hooksAddPermanent', array(
                "hook" => "driverUserLikeLogout",
                "file" => $path."drivers/uauiHandlers.php",
                "func" => "driverUauiHandlers::hookddriverUserLikeLogout"
            ));
            driverCommand::run('hooksAddPermanent', array(
                "hook" => "driverUserSessionStarted",
                "file" => $path."drivers/uauiHandlers.php",
                "func" => "driverUauiHandlers::hookdriverUserSessionStarted"
            ));
            $npass = urlencode(driverTools::passNew(true, true, true, true, 50));
            driverConfig::getCFG()->getSection('[usergui]')->set('cookie_salt', "'".$npass."'");
            driverConfig::getCFG()->save();
        }

        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Install modulo requirements."), 
                "parameters" => array(), 
                "response" => array(),
                "type" => array(
                    "parameters" => array(), 
                    "response" => array(),
                ),
                "echo" => false
            );
        }
        
        public static function getAccess($ignore = "") {
            $me = __FILE__;
            return parent::getAccess($me);
        }
        
//        public static function getAccessFlags() {
//            return driverUser::PERMISSION_FILE_GROUP_EXECUTE;
//        }
        
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
return new commandUauiInstall();
<?php

//http://www.bitrepository.com/php-autologin.html
class driverUauiHandlers {
    
    /**
     * "name": "driverUserNewLogin",
     * "description": "Allow react to driverUser::logIn when user get login. The user session is opened to read/write.",
     * "parameters": {}
     */
    public static function hookdriverUserNewLogin($params) {
        if (!isset($_POST['userremember'])) {
            // The user dont like remember session
            setcookie (
                    driverConfig::getCFG()->getSection('[usergui]')->get('cookie_name'), 
                    "", time() - 3600);
            return;
        }
        $allowRemember = driverConfig::getCFG()->getSection('[usergui]')->getAsBoolean('allow_remember');
        if ($allowRemember && driverUser::isLoged()) {
            $uid = driverUser::getID(true);
            
            $sql = "select `mail`, `pass` from `node_user` where `id` = ".$uid;
            $q = dbConn::Execute($sql);
            if ($q->EOF) return; // Ops, hacking?
            
            $pass = $q->fields['pass'];
            $mail = $q->fields['mail'];
            $cookie_time = driverConfig::getCFG()->getSection('[usergui]')->get('cookie_expire');
            $salt = driverConfig::getCFG()->getSection('[usergui]')->get('cookie_salt');
            $password_hash = driverUser::passwordObfuscation($uid.$salt.$pass.$mail);
            setcookie(
                driverConfig::getCFG()->getSection('[usergui]')->get('cookie_name'),
                'usr='.$mail.
                '&hash='.$password_hash, 
                time() + $cookie_time
            );
        }
    }
    
    /**
     * "name": "driverUserSessionStarted",
     * "description": "Allow react to driverUser::sessionStart after start session. The user session is opened to read/write.",
     * "parameters": {}
     * @param type $params
     */
    public static function hookdriverUserSessionStarted($params) {
        $allowRemember = driverConfig::getCFG()->getSection('[usergui]')->getAsBoolean('allow_remember');
        if (!$allowRemember) return;
        
        if ($_SESSION["is_loged"] == 0) {
            // We can restart session by cookies
            $cookie_name = driverConfig::getCFG()->getSection('[usergui]')->get('cookie_name');
            // Check if the cookie exists
            if(isSet($_COOKIE[$cookie_name])) {
                parse_str($_COOKIE[$cookie_name], $cookVars);
                // Make a verification: $uid.$salt.$pass.$mail
                $salt = driverConfig::getCFG()->getSection('[usergui]')->get('cookie_salt');
                $user = $cookVars['usr'];
                $sql = "select * from `node_user` where `mail` = '$user'";
                $q = dbConn::Execute($sql);
                if ($q->EOF) return; // Unknowed user
                $hash = driverUser::passwordObfuscation($q->fields['id'].$salt.$q->fields['pass'].$q->fields['mail']);
                if($hash == $cookVars['hash']) {
                    // Register the session
                    $_SESSION["is_loged"] = 1;
                    $_SESSION["user_id"] = $q->fields["id"];
                    $sql = "SELECT * FROM `node_relation_user_groups_group` where `type1` = ".$q->fields["id"];
                    $q = dbConn::Execute($sql);
                    $_SESSION["user_groups"] = array();
                    while(!$q->EOF) {
                        $_SESSION["user_groups"][] = $q->fields["type2"];
                        $q->MoveNext();
                    }
                }
            }
        }
    }

    /**
     * "name": "driverUserLikeLogout",
     * "description": "Allow react to driverUser::logOut before destroy session. The user session is opened to read/write.",
     * "parameters": {}
     * @param type $params
     */
    public static function hookddriverUserLikeLogout($params) {
        // The user dont like remember session
            setcookie (
                    driverConfig::getCFG()->getSection('[usergui]')->get('cookie_name'), 
                    "", time() - 3600
            );
    }
    
}
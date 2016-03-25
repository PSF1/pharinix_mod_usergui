<?php
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandUauiNavLoginForm")) {
    class commandUauiNavLoginForm extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $context = &driverCommand::getRegister("url_context");
            if (!isset($context['$rewrite'])) {
                $context['$rewrite'] = '';
            }
            // http://bootsnipp.com/snippets/featured/nav-bar-with-popup-sign-in
?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Sign in'); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                <li>
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form" role="form" 
                                  enctype="application/x-www-form-urlencoded" method="post" 
                                  action="<?php echo CMS_DEFAULT_URL_BASE; ?>" 
                                  accept-charset="UTF-8" id="login-nav">
                                <input type="hidden" name="cmd" value="startSession"/>
                                <input type="hidden" name="command" value="goTo"/>
                                <input type="hidden" name="interface" value="nothing"/>
                                <input type="hidden" name="gtpath" value="<?php echo $context['$rewrite']; ?>"/>
                                <div class="form-group">
                                    <label class="sr-only" for="usrmail"><?php echo __('Email address'); ?></label>
                                    <input type="email" class="form-control" id="usrmail" name="user" placeholder="<?php echo __('Email address'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="userpass"><?php echo __('Password'); ?></label>
                                    <input type="password" class="form-control" id="userpass" placeholder="<?php echo __('Password'); ?>" name="pass" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="userremember"> <?php echo __('Remember me'); ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block"><?php echo __('Sign in'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
<?php
        }

        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Show login form to integrate in navbar."), 
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
return new commandUauiNavLoginForm();
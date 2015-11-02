<?php
if (!defined("CMS_VERSION")) {
    header("HTTP/1.0 404 Not Found");
    die("");
}

if (!class_exists("commandUauiEditMyAccount")) {

    class commandUauiEditMyAccount extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            echo '<legend>My account</legend>';
            if (driverUser::getID(true) == driverUser::getUserIDByMail("guest@localhost")) {
                echo driverCommand::getAlert("User is not loged.");
                return;
            }
            $path = driverCommand::run('modGetPath', array('name' => 'pharinix_mod_usergui'));
            driverCommand::run('incFormValidator');
            $user = driverCommand::run("getNode", array("nodetype" => "user", "node" => driverUser::getID(true)));
            ?>
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab"><?php __e('Profile'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <form class="form-horizontal" id="frmUser" data-user="<?php echo driverUser::getID(true); ?>">
                            <fieldset>
                                <p>&nbsp;</p>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtName"><?php __e('User name'); ?></label>
                                    <div class="col-md-5">
                                        <input id="txtName" name="txtName"
                                               value ="<?php echo $user[driverUser::getID(true)]["name"]; ?>"
                                               type="text"
                                               placeholder="<?php __e('User name'); ?>"
                                               class="form-control input-md" required="">
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtTitle"><?php __e('Name'); ?></label>
                                    <div class="col-md-5">
                                        <input id="txtTitle" name="txtTitle"
                                               value ="<?php echo $user[driverUser::getID(true)]["title"]; ?>"
                                               type="text"
                                               placeholder="<?php __e('Name'); ?>"
                                               class="form-control input-md" required="">
                                    </div>
                                </div>

                                <!-- Password input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtPass1"><?php __e('New password'); ?></label>
                                    <div class="col-md-5">
                                        <input id="txtPass1" name="txtPass1"
                                               type="password"
                                               placeholder="<?php __e('Password');?>"
                                               class="form-control input-md">
                                        <span class="help-block"><?php __e('Leave blank to preserve password.'); ?></span>
                                    </div>
                                </div>

                                <!-- Password input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtPass2"><?php __e('Retype password'); ?></label>
                                    <div class="col-md-5">
                                        <input id="txtPass2" name="txtPass2"
                                               type="password"
                                               placeholder="<?php __e('Password'); ?>"
                                               class="form-control input-md">
                                        <span class="help-block"><?php __e('To verify the new password you must write it two times.'); ?></span>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtMail"><?php __e('eMail'); ?></label>
                                    <div class="col-md-5">
                                        <input id="txtMail" name="txtMail"
                                               value ="<?php echo $user[driverUser::getID(true)]["mail"]; ?>"
                                               type="email"
                                               placeholder="<?php __e('eMail'); ?>"
                                               class="form-control input-md"
                                               disabled="">
                                        <span class="help-block"><?php __e('Used to login.'); ?></span>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success" id="cmdSave"><span class="glyphicon glyphicon-cloud-upload"></span> <?php __e('Save'); ?></button>
            <?php
            $js = file_get_contents($path['path']."js/uauiEditMyAccount.js");
            echo "<script>".$js."</script>";
            echo "</div>";
        }

        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Show a form to edit the current user."),
                "parameters" => array(),
                "response" => array(),
                "type" => array(
                    "parameters" => array(),
                    "response" => array(),
                ),
                "echo" => true
            );
        }

        public static function getAccess($ignore = "") {
            $me = __FILE__;
            return parent::getAccess($me);
        }

        public static function getAccessFlags() {
            return driverUser::PERMISSION_FILE_ALL_EXECUTE;
        }
    }

}
return new commandUauiEditMyAccount();

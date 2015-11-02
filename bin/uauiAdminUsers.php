<?php
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandUauiAdminUsers")) {
    class commandUauiAdminUsers extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $path = driverCommand::run('modGetPath', array('name' => 'pharinix_mod_usergui'));
            driverCommand::run('incBSModal');
            driverCommand::run('incBS3Dialog');
?>
<?php
//            $css = file_get_contents($path['path']."css/uauiAdminUsers.css");
//            $reg = &self::getRegister("customcss");
//            $reg .= $css;
//            $js = file_get_contents($path['path']."js/uauiAdminUsers.js");
//            $reg = &self::getRegister("customscripts");
//            $reg .= $js;
            echo "<legend>".__('User list')."</legend>";
?>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
            <button class="btn btn-sm btn-default btnAdd" type="button"
                    data-toggle="tooltip"
                    data-original-title="<?php __e("Add user");?>"><i class="glyphicon glyphicon-plus"></i> <?php __e("Add");?></button>
        </div>
            <!-- User list -->
            <div class="well col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
<?php
            $grupos = driverNodes::getNodes(array("nodetype" => "group"), false);
            $users = driverNodes::getNodes(array("nodetype" => "user"), false);
            foreach($users as $userId => $user) {
                if ($user["mail"] == "guest@localhost") {
                    continue;
                }
?>
                <div class="row user-row">
                    <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                        <img class="img-circle"
                             src="<?php echo CMS_DEFAULT_URL_BASE.$path['path']; ?>assets/avatar_2x.png"
                             alt="...">
                    </div>
                    <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                        <strong><?php echo self::getUserDropdownTitle($user); ?></strong><br>
                        <span class="text-muted"><?php echo self::getUserDropdownSubtitle($user, $grupos); ?></span>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".user-<?php echo $userId; ?>">
                        <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                    </div>
                </div>
                <div class="row user-infos user-<?php echo $userId; ?>">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php __e('User record');?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-10 col-sm-10 hidden-md hidden-lg">
                                        <strong><?php echo self::getUserDropdownTitle($user); ?></strong><br>
                                        <dl>
                                            <dt><?php __e("Mail");?>:</dt>
                                            <dd><?php echo $user["mail"]; ?></dd>
                                            <dt><?php __e('Groups');?>:</dt>
                                            <dd><?php echo self::groupsToTitle($user["groups"], $grupos); ?></dd>
                                            <dt><?php __e('Registed');?>:</dt>
                                            <dd><?php echo $user["created"].' by '.driverUser::getUserName($user["creator"]) ?></dd>
                                            <dt><?php __e('Modified');?>:</dt>
                                            <dd><?php echo $user["modified"].' by '.driverUser::getUserName($user["modifier"]) ?></dd>
                                        </dl>
                                    </div>
                                    <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                        <strong><?php echo self::getUserDropdownTitle($user); ?></strong><br>
                                        <table class="table table-user-information">
                                            <tbody>
                                                <tr>
                                                    <td><?php __e("Mail");?>:</td>
                                                    <td><?php echo $user["mail"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php __e('Groups');?>:</td>
                                                    <td><?php echo self::groupsToTitle($user["groups"], $grupos); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php __e('Registed');?>:</td>
                                                    <td><?php echo $user["created"].' by '.driverUser::getUserName($user["creator"]) ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?php __e('Modified');?>:</td>
                                                    <td><?php echo $user["modified"].' by '.driverUser::getUserName($user["modifier"]) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-sm btn-warning btnEdit" type="button"
                                            user="<?php echo $userId; ?>"
                                            data-toggle="tooltip"
                                            data-original-title="<?php __e('Edit this user');?>"><i class="glyphicon glyphicon-edit"></i></button>
<!--                                <button class="btn btn-sm btn-primary" type="button"
                                        data-toggle="tooltip"
                                        data-original-title="Send message to user"><i class="glyphicon glyphicon-envelope"></i></button>-->
                                <span class="pull-right">
                                    <button class="btn btn-sm btn-danger btnDel" type="button"
                                            user="<?php echo self::getUserDropdownTitle($user); ?>"
                                            userid="<?php echo $userId; ?>"
                                            data-toggle="tooltip"
                                            data-original-title="<?php __e('Delete this user');?>"><i class="glyphicon glyphicon-remove"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            }
?>
            </div> <!-- /User list -->
            <!-- Modal user form -->
            <div id="userForm" class="modal fade" tabindex="-1" style="display: none;"></div>
            <div id="alertModal" class="modal fade" tabindex="-1">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title"><?php __e('Alert');?></h4>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" data-default="modal" class="btn" data-dismiss="modal"><?php __e('Ok');?></button>
                </div>
              </div>
            <div id="confirmModal" class="modal fade" tabindex="-1">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title"><?php __e('Alert');?></h4>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" data-default="modal" class="btn" data-dismiss="modal"><?php __e('Cancel');?></button>
                  <button type="button" data-default="modal" class="btn btn-primary confirmModalOk" data-dismiss="modal"><?php __e('Ok');?></button>
                </div>
              </div>
<?php
            $css = file_get_contents($path['path']."css/uauiAdminUsers.css");
            echo "<style>$css</style>";
            $js = file_get_contents($path['path']."js/uauiAdminUsers.js");
            echo "<script>".$js."</script>";
        }

        protected static function getUserDropdownTitle($user) {
            return $user["name"]." / ".$user["title"];
        }
        
        protected static function getUserDropdownSubtitle($user, $grupos) {
            return $user["mail"].". ".__("Groups").": ". self::groupsToTitle($user["groups"], $grupos);
        }
        
        protected static function groupsToTitle($ids, $grupos) {
            $resp = array();
            foreach ($ids as $id) {
                $resp[] = '\''.$grupos[$id]["title"].'\'';
            }
            return join(", ", $resp);
        }
        
        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Show a user management form."), 
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
return new commandUauiAdminUsers();
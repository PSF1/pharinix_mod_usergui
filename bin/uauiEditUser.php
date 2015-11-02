<?php
if (!defined("CMS_VERSION")) { header("HTTP/1.0 404 Not Found"); die(""); }

if (!class_exists("commandUauiEditUser")) {
    class commandUauiEditUser extends driverCommand {

        public static function runMe(&$params, $debug = true) {
            $params = array_merge(array(
                "user" => 0,
            ), $params);
            $path = driverCommand::run('modGetPath', array('name' => 'pharinix_mod_usergui'));
            
            ?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php __e('Edit user');?></h4>
</div>
<?php
        $user = driverNodes::getNodes(array(
                "nodetype" => 'user',
                "where" => "`id` = ".$params["user"],
            ), false);
        if (count($user) == 0) {
            echo driverCommand::getAlert(__("User not found..."));
        } else {
            //$grupos = driverCommand::run("getNodes", array("nodetype" => "group"));
            $grupos = driverNodes::getNodes(array("nodetype" => "group"), false);
            $fid = driverCommand::run("newID");
            $fid = "frm".str_replace(".", "", $fid["id"]);
            driverCommand::run('incDualListbox');
            driverCommand::run('incFormValidator');
            ?>
<div class="modal-body">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab"><?php __e('General');?></a></li>
		<li><a href="#tab2" data-toggle="tab"><?php __e('Groups');?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
                    <form class="form-horizontal" id="<?php echo $fid;?>" user="<?php echo $params["user"];?>">
                    <fieldset>
                        <p>&nbsp;</p>
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="txtName"><?php __e('User name'); ?></label>  
                      <div class="col-md-8">
                      <input id="txtName" name="txtName" 
                             value ="<?php echo $user[$params["user"]]["name"]; ?>"
                             type="text" 
                             placeholder="<?php __e('User name'); ?>" 
                             class="form-control input-md" required="">
                      </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="txtTitle"><?php __e('Name'); ?></label>  
                      <div class="col-md-8">
                      <input id="txtTitle" name="txtTitle" 
                             value ="<?php echo $user[$params["user"]]["title"]; ?>"
                             type="text" 
                             placeholder="<?php __e('Name'); ?>" 
                             class="form-control input-md" required="">
                      </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="txtPass1"><?php __e('New password'); ?></label>
                      <div class="col-md-8">
                        <input id="txtPass1" name="txtPass1"
                             type="password" 
                             placeholder="<?php __e('Password');?>" 
                             class="form-control input-md">
                        <span class="help-block"><?php __e('Leave blank to preserve password.'); ?></span>
                      </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="txtPass2"><?php __e('Retype password'); ?></label>
                      <div class="col-md-8">
                        <input id="txtPass2" name="txtPass2"
                             type="password" 
                             placeholder="<?php __e('Password'); ?>" 
                             class="form-control input-md">
                        <span class="help-block"><?php __e('To verify the new password you must write it two times.'); ?></span>
                      </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="txtMail"><?php __e('eMail'); ?></label>  
                      <div class="col-md-8">
                      <input id="txtMail" name="txtMail"
                             value ="<?php echo $user[$params["user"]]["mail"]; ?>" 
                             type="email" 
                             placeholder="<?php __e('eMail'); ?>" 
                             class="form-control input-md" 
                             required="">
                      <span class="help-block"><?php __e('Used to login.'); ?></span>
                      </div>
                    </div>

                    </fieldset>
                    </form>
                </div>
		<div class="tab-pane" id="tab2">
                    <p>&nbsp;</p>
                    <select id="selectGrp" name="selectGrp" multiple>
                    <?php
                    foreach($grupos as $idGrp => $grp) {
                        $presel = in_array($idGrp, $user[$params["user"]]["groups"]);
                        if ($grp["title"] != 'sudoers' || ($grp["title"] == 'sudoers' && driverUser::isSudoed())) {
                            echo '<option value="'.$idGrp.'" '.
                                ($presel?"selected":"").
                                '> '.$grp["title"].' </option>';
                        }
                    }
                    ?>
                    </select>
                    <span class="help-block"><?php __e('Groups determine user permissions.'); ?></span>
                </div>
	</div>
</div>
<?php
        }
?>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn"><?php __e('Cancel');?></button>
<?php
        if ($params["user"] != 0) {
?>
	<button type="button" class="btn btn-success" id="cmdSave-<?php echo $fid;?>"><?php __e('Save'); ?></button>
            <?php
            $js = file_get_contents($path['path']."js/uauiEditUser.js");
            echo "<script>".str_replace("[frmid]", $fid, $js)."</script>";
        }
        echo "</div>";
        }

        public static function getHelp() {
            return array(
                "package" => "pharinix_mod_usergui",
                "description" => __("Show edit user form."), 
                "parameters" => array(
                    "user" => __("User ID to edit.")
                ), 
                "response" => array(),
                "type" => array(
                    "parameters" => array(
                        "user" => "integer"
                    ), 
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
//        
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
return new commandUauiEditUser();
<?php
/*
 -------------------------------------------------------------------------
 Archibp plugin for GLPI
 Copyright (C) 2009-2021 by Eric Feron.
 -------------------------------------------------------------------------

 LICENSE
      
 This file is part of Archibp.

 Archibp is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 at your option any later version.

 Archibp is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Archibp. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

if (strpos($_SERVER['PHP_SELF'],"dropdownTypeArchibp.php")) {
   $AJAX_INCLUDE=1;
   include ('../../../inc/includes.php');
   header("Content-Type: text/html; charset=UTF-8");
   Html::header_nocache();
}

Session::checkCentralAccess();

// Make a select box
if (isset($_POST["tasktype"])) {
   $used = [];

   // Clean used array
   if (isset($_POST['used']) && is_array($_POST['used']) && (count($_POST['used']) > 0)) {
      $query = "SELECT `id`
                FROM `glpi_plugin_archibp_tasks`
                WHERE `id` IN (".implode(',',$_POST['used']).")
                      AND `plugin_archibp_tasktypes_id` = '".$_POST["tasktype"]."'";

      foreach ($DB->request($query) AS $data) {
         $used[$data['id']] = $data['id'];
      }
   }

   Dropdown::show('PluginArchibpTask',
                  ['name'      => $_POST['myname'],
					'used'      => $used,
					'width'     => '50%',
					'entity'    => $_POST['entity'],
					'rand'      => $_POST['rand'],
					'condition' => ["glpi_plugin_archibp_tasks.plugin_archibp_tasktypes_id"=>$_POST["tasktype"]]]);

}

?>

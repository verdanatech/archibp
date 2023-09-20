<?php
/*
 -------------------------------------------------------------------------
 Archibp plugin for GLPI
 Copyright (C) 2009-2018 by Eric Feron.
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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginArchibpConfigbp extends CommonDBTM {

   public $dohistory=true;
   static $rightname = "plugin_archibp_configuration";
   protected $usenotepad         = true;
   
   static function getTypeName($nb=0) {

      return __('Business Process Config', 'archibp');
   }

   // search fields from GLPI 9.3 on
   function rawSearchOptions() {

      $tab = [];
//      if (version_compare(GLPI_VERSION,'9.2','le')) return $tab;

      $tab[] = [
         'id'   => 'common',
         'name' => self::getTypeName(2)
      ];

      $tab[] = [
         'id'            => '2',
         'table'         => $this->getTable(),
         'field'         => 'name',
         'name'          => __('Name'),
         'datatype'		 => 'itemlink',
		 'massiveaction' => false
      ];


      $tab[] = [
         'id'       => '3',
         'table'    => PluginArchibpConfigbpFieldgroup::getTable(),
         'field'    => 'name',
         'name'     => PluginArchibpConfigbpFieldgroup::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '4',
         'table'    => PluginArchibpConfigbpDatatype::getTable(),
         'field'    => 'name',
         'name'     => PluginArchibpConfigbpDatatype::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '5',
         'table'    => PluginArchibpConfigbpDbfieldtype::getTable(),
         'field'    => 'name',
         'name'     => PluginArchibpConfigbpDbfieldtype::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '10',
         'table'    => $this->getTable(),
         'field'    => 'description',
         'name'     => __('Description'),
         'datatype' => 'text'
      ];

      $tab[] = [
         'id'       => '11',
         'table'    => $this->getTable(),
         'field'    => 'row',
         'name'     => __('Row', 'archibp'),
         'datatype' => 'text'
      ];

      $tab[] = [
         'id'       => '12',
         'table'    => PluginArchibpConfigbpHalign::getTable(),
         'field'    => 'name',
         'name'     => PluginArchibpConfigbpHalign::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '13',
         'table'    => $this->getTable(),
         'field'    => 'is_linked',
         'name'     => __('Is linked to another class', 'archibp'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '14',
         'table'    => PluginArchibpConfigbpLink::getTable(),
         'field'    => 'name',
         'name'     => PluginArchibpConfigbpLink::getTypeName(1),
         'datatype' => 'dropdown'
      ];

      $tab[] = [
         'id'       => '15',
         'table'    => $this->getTable(),
         'field'    => 'nosearch',
         'name'     => __('Search disabled ?', 'archisw'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '16',
         'table'    => $this->getTable(),
         'field'    => 'massiveaction',
         'name'     => __('Massive action allowed ?', 'archisw'),
         'datatype' => 'bool'
      ];

      $tab[] = [
         'id'       => '17',
         'table'    => $this->getTable(),
         'field'    => 'forcegroupby',
         'name'     => __('Force group by ?', 'archibp'),
         'datatype' => 'bool'
      ];

       $tab[] = [
         'id'            => '72',
         'table'         => $this->getTable(),
         'field'         => 'id',
         'name'          => __('ID'),
         'datatype'      => 'number'
      ];

      return $tab;
   }

   //define header form
   function defineTabs($options=[]) {

      $ong = [];
      $this->addDefaultFormTab($ong);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }

   function showForm ($ID, $options=[]) {

      $this->initForm($ID, $options);
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
     //name
      echo "<td>".__('Name')."</td>";
      echo "<td>";
      echo Html::input('name',['value' => $this->fields['name'], 'id' => "name" , 'width' => '100%']);
      echo Html::showToolTip("A name must be lowercase, start with a letter, contain only letters, numbers or underscores.<br/>If the field is a dropdown, the name must end with '_id', otherwise it may not end with '_id'.<br/>Some words are reserved : name, completename, id, date_mod, is_recursive, entities_id, is_deleted, ancestors_cache, sons_cache.",['applyto' => 'name']);
      echo "</td>";
      //skip 2nd column
      echo "<td></td>";
      echo "<td></td>";
     //name
      echo "<td>".__('Description')."</td>";
      echo "<td>";
      echo Html::input('description',['value' => $this->fields['description'], 'id' => "description" , 'width' => '100%']);
      echo "</td>";
 	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //field group
      echo "<td>".__('Field group', 'archibp').": </td>";
      echo "<td>";
      Dropdown::show('PluginArchibpConfigbpFieldgroup', ['value' => $this->fields['plugin_archibp_configbpfieldgroups_id']]);
      echo "</td>";
      //row
      echo "<td>".__('Row', 'archibp')."</td>";
      echo "<td>";
      echo Html::input('row',['value' => $this->fields['row'], 'id' => "row", 'size' => 2]);
      echo "</td>";
      //horizontal alignment
      echo "<td>".__('Hor.alignment', 'archibp')."</td>";
      echo "<td>";
      Dropdown::show('PluginArchibpConfigbpHalign', ['value' => $this->fields['plugin_archibp_configbphaligns_id']]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //db field type
      echo "<td>".__('DB Field Type', 'archibp').": </td>";
      echo "<td>";
      Dropdown::show('PluginArchibpConfigbpDbfieldtype', ['value' => $this->fields['plugin_archibp_configbpdbfieldtypes_id']]);
      echo "</td>";
      //search datatype
      echo "<td>".__('Search Data Type', 'archibp').": </td>";
      echo "<td>";
      Dropdown::show('PluginArchibpConfigbpDatatype', ['value' => $this->fields['plugin_archibp_configbpdatatypes_id']]);
      echo "</td>";
      //readonly
      echo "<td>".__('Is read-only ?', 'archibp').": </td>";
      echo "<td>";
      Dropdown::showYesNo('is_readonly',$this->fields['is_readonly']);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //nosearch
      echo "<td>".__('Search disabled ?', 'archibp').": </td>";
      echo "<td>";
      Dropdown::showYesNo('nosearch',$this->fields['nosearch']);
      echo "</td>";
      //massiveaction
      echo "<td>".__('Massive action allowed ?', 'archibp')."</td>";
      echo "<td>";
      Dropdown::showYesNo('massiveaction',$this->fields['massiveaction']);
      echo "</td>";
      //forcegroupby
      echo "<td>".__('Force group by ?', 'archibp')."</td>";
      echo "<td>";
      Dropdown::showYesNo('forcegroupby',$this->fields['forcegroupby']);
      echo "</td>";
	  echo "</tr>";
	  
      echo "<tr class='tab_bg_1'>";
      //islinked
      echo "<td>".__('Is linked to another class ?', 'archibp').": </td>";
      echo "<td>";
      Dropdown::showYesNo('is_linked',$this->fields['is_linked']);
      echo "</td>";
      //linked table
      echo "<td>".__('Linked class', 'archibp')."</td>";
      echo "<td>";
      Dropdown::show('PluginArchibpConfigbpLink', ['value' => $this->fields['plugin_archibp_configbplinks_id']]);
      echo "</td>";
      //link field
      echo "<td>".__('Linked by field', 'archibp')."</td>";
      echo "<td>";
      echo Html::input('linkfield',['value' => $this->fields['linkfield'], 'id' => "linkfield"]);
      echo "</td>";
	  echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      //join parameters
      echo "<td>".__('Join parameters', 'archibp')."</td>";
      echo "<td colspan='5'>";
      echo Html::input('joinparams',['value' => $this->fields['joinparams'], 'id' => "joinparams"]);
      echo "</td>";
	  echo "</tr>";
      $this->showFormButtons($options);

      return true;
   }
}

?>

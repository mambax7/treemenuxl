<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Ruby Willemsen (AKA dAWiLbY)                                      //
// URL: http://www.rubywillemsen.nl/                                         //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
  function b_show_treemenuxl($options)
  {
    include_once(XOOPS_ROOT_PATH."/modules/treemenuxl/include/treemenuxl.php");
    include_once(XOOPS_ROOT_PATH."/modules/treemenuxl/include/browser_detection.php");

    global $xoopsUser,$xoopsModule;

    $block = array();

    $block['tree_root'] = new HTML_TreeMenuXL();
    $block['homepage']  = array("icon"=>"homepage.gif");
    $block['folder']    = array("icon"=>"folder.gif");
    $block['document']  = array("icon"=>"document.gif");
    $block['admin']     = array("icon"=>"editicon.gif");

    $block['tree_start'] = new HTML_TreeNodeXL(_TM_HOME, XOOPS_URL.'/index.php', $block['homepage']);
    $block['tree_root']->addItem($block['tree_start']);

    $module_handler =& xoops_gethandler('module');
    $criteria = new CriteriaCompo(new Criteria('hasmain', 1));
    $criteria->add(new Criteria('isactive', 1));
    $criteria->add(new Criteria('weight', 0, '>'));
    $modules =& $module_handler->getObjects($criteria, true);
    $moduleperm_handler =& xoops_gethandler('groupperm');
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $read_allowed =& $moduleperm_handler->getItemIds('module_read', $groups);
    $admin_allowed =& $moduleperm_handler->getItemIds('module_admin', $groups);
    foreach (array_keys($modules) as $i) {
      if (in_array($modules[$i]->getVar('mid'), $read_allowed)) {
        $block['tree_link'][$i] = new HTML_TreeNodeXL($modules[$i]->getVar('name'), XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/', $block['folder']);
        $sublinks =& $modules[$i]->subLink();
        if ($options[1]=="yes" && browser_detection('browser') != 'opera') {
          if (count($sublinks) > 0) {
          foreach($sublinks as $sublink) {
            $block['tree_link'][$i]->addItem(new HTML_TreeNodeXL($sublink['name'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$sublink['url'], $block['document']));
          }
          if ($options[2]=="yes") {
            if ($modules[$i]->getVar('hasadmin')=="1" && $modules[$i]->getVar('isactive')=="1") {
              if (in_array($modules[$i]->getVar('mid'), $admin_allowed)) {
                $block['tree_sublink'][$i] = &$block['tree_link'][$i]->additem (new HTML_TreeNodeXL('Admin', XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/admin/index.php', $block['folder']));
                $adminmenuitems = $modules[$i]->getAdminMenu();
                if ($modules[$i]->getVar('hasnotification') || ($modules[$i]->getInfo('config') && is_array($modules[$i]->getInfo('config'))) || ($modules[$i]->getInfo('comments') && is_array($modules[$i]->getInfo('comments')))) {
                  $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL(_PREFERENCES, XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$modules[$i]->getVar('mid'), $block['admin']));
                }
                if (count($adminmenuitems) > 0) {
                  foreach($adminmenuitems as $adminmenuitem) {
                    $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL($adminmenuitem['title'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$adminmenuitem['link'], $block['admin']));
                  }
                }
              }
            }
          }
        } else {
          $block['modules'][$i]['sublinks'] = array();
          if ($options[2]=="yes") {
            if ($modules[$i]->getVar('hasadmin')=="1" && $modules[$i]->getVar('isactive')=="1") {
              if (in_array($modules[$i]->getVar('mid'), $admin_allowed)) {
                $block['tree_sublink'][$i] = &$block['tree_link'][$i]->additem (new HTML_TreeNodeXL('Admin', XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/admin/index.php', $block['folder']));
                $adminmenuitems = $modules[$i]->getAdminMenu();
                if ($modules[$i]->getVar('hasnotification') || ($modules[$i]->getInfo('config') && is_array($modules[$i]->getInfo('config'))) || ($modules[$i]->getInfo('comments') && is_array($modules[$i]->getInfo('comments')))) {
                  $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL(_PREFERENCES, XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$modules[$i]->getVar('mid'), $block['admin']));
                }
                if (count($adminmenuitems) > 0) {
                  foreach($adminmenuitems as $adminmenuitem) {
                    $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL($adminmenuitem['title'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$adminmenuitem['link'], $block['admin']));
                  }
                }
              }
            }
          }
        }
      } else {
        if ((count($sublinks) > 0) && (isset($xoopsModule)) && ($i==$xoopsModule->getVar('mid'))) {
          foreach($sublinks as $sublink) {
            $block['tree_link'][$i]->addItem(new HTML_TreeNodeXL($sublink['name'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$sublink['url'], $block['document']));
          }
          if ($options[2]=="yes") {
             if ($modules[$i]->getVar('hasadmin')=="1" && $modules[$i]->getVar('isactive')=="1") {
                if (in_array($modules[$i]->getVar('mid'), $admin_allowed)) {
                  $block['tree_sublink'][$i] = &$block['tree_link'][$i]->additem (new HTML_TreeNodeXL('Admin', XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/admin/index.php', $block['folder']));
                  $adminmenuitems = $modules[$i]->getAdminMenu();
                  if ($modules[$i]->getVar('hasnotification') || ($modules[$i]->getInfo('config') && is_array($modules[$i]->getInfo('config'))) || ($modules[$i]->getInfo('comments') && is_array($modules[$i]->getInfo('comments')))) {
                    $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL(_PREFERENCES, XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$modules[$i]->getVar('mid'), $block['admin']));
                  }
                  if ((count($adminmenuitems) > 0) && (isset($xoopsModule)) && ($i==$xoopsModule->getVar('mid'))) {
                    foreach($adminmenuitems as $adminmenuitem) {
                      $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL($adminmenuitem['title'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$adminmenuitem['link'], $block['admin']));
                    }
                  }
                }
              }
            }
          } else {
            if ((isset($xoopsModule)) && ($i==$xoopsModule->getVar('mid'))) {
              $block['modules'][$i]['sublinks'] = array();
              if ($options[2]=="yes") {
                if ($modules[$i]->getVar('hasadmin')=="1" && $modules[$i]->getVar('isactive')=="1") {
                  if (in_array($modules[$i]->getVar('mid'), $admin_allowed)) {
                    $block['tree_sublink'][$i] = &$block['tree_link'][$i]->additem (new HTML_TreeNodeXL('Admin', XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/admin/index.php', $block['folder']));
                    $adminmenuitems = $modules[$i]->getAdminMenu();
                    if ($modules[$i]->getVar('hasnotification') || ($modules[$i]->getInfo('config') && is_array($modules[$i]->getInfo('config'))) || ($modules[$i]->getInfo('comments') && is_array($modules[$i]->getInfo('comments')))) {
                      $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL(_PREFERENCES, XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$modules[$i]->getVar('mid'), $block['admin']));
                    }
                    if ((count($adminmenuitems) > 0) && (isset($xoopsModule)) && ($i==$xoopsModule->getVar('mid'))) {
                      foreach($adminmenuitems as $adminmenuitem) {
                        $block['tree_sublink'][$i]->addItem(new HTML_TreeNodeXL($adminmenuitem['title'], XOOPS_URL.'/modules/'.$modules[$i]->getVar('dirname').'/'.$adminmenuitem['link'], $block['admin']));
                      }
                    }
                  }
                }
              }
            }
          }
        }
        $block['tree_root']->addItem($block['tree_link'][$i]);
      }
    }
    $block['treemenuxl'] = new HTML_TreeMenu_DHTMLXL($block['tree_root'], array("images"=>XOOPS_URL."/modules/treemenuxl/images/".$options[0].""));
    $block['treemenuxl'] = $block['treemenuxl']->toHTML();
    return $block;
  }

  function b_edit_treemenuxl($options)
  {
    $form  = "\n\n<!-- begin TreemenuXL -->\n";
    $form .= "<table style=\"border: 1px outset;\" cellspacing=\"3\" cellpadding=\"1\">\n";
    $form .= "<tr><td colspan=\"3\"align=\"center\"><b><i>"._TM_SHOWMENU."</i></b></td></tr>\n";
    if ($options[0]=="explorer") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_EXPLORER."</td><td><input type=\"radio\" name=\"options[0]\" value=\"explorer\"".$checked." /></td></tr>\n";
    if ($options[0]=="extra") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_EXTRA."</td><td><input type=\"radio\" name=\"options[0]\" value=\"extra\"".$checked." /></td></tr>\n";
    if ($options[0]=="round") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_ROUND."</td><td><input type=\"radio\" name=\"options[0]\" value=\"round\"".$checked." /></td></tr>\n";
    if ($options[0]=="small") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_SMALL."</td><td><input type=\"radio\" name=\"options[0]\" value=\"small\"".$checked." /></td></tr>\n";
    if ($options[0]=="standard") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_STANDARD."</td><td><input type=\"radio\" name=\"options[0]\" value=\"standard\"".$checked." /></td></tr>\n";

    // should a link show a 'cross' if there are sublinks?
    $form .= "<tr><td colspan=\"3\"align=\"center\"><b><i>"._TM_SHOWLINK."</i></b></td></tr>\n";
    if ($options[1]=="yes") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_YES."</td><td><input type=\"radio\" name=\"options[1]\" value=\"yes\"".$checked." /></td></tr>\n";
    if ($options[1]=="no") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_NO."</td><td><input type=\"radio\" name=\"options[1]\" value=\"no\"".$checked." /></td></tr>\n";

  	// should adminlinks be showed if a user is admin?
    $form .= "<tr><td colspan=\"3\"align=\"center\"><b><i><font color=\"red\">"._TM_SHOWADMIN."</font></i></b></td></tr>\n";
    if ($options[2]=="yes") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_YES."</td><td><input type=\"radio\" name=\"options[2]\" value=\"yes\"".$checked." /></td></tr>\n";
    if ($options[2]=="no") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_NO."</td><td><input type=\"radio\" name=\"options[2]\" value=\"no\"".$checked." /></td></tr>\n";
    $form .= "</table>\n";
    $form .= "<!-- end TreemenuXL in ".$options[0]." style -->\n\n";

    return $form;
  }

  function b_show_treemenuxl_user($options)
  {
    include_once(XOOPS_ROOT_PATH."/modules/treemenuxl/include/treemenuxl.php");

    global $xoopsUser,$xoopsModule;

    if (is_object($xoopsUser)) {
      $pm_handler =& xoops_gethandler('privmessage');
      $block = array();

      $block['tree_root'] = new HTML_TreeMenuXL();
      $block['folder']    = array("icon"=>"folder.gif");
      $block['document']  = array("icon"=>"document.gif");
      $block['document_highlight']  = array("icon"=>"document.gif","cssclass"=>"highlight");
      $block['admin']     = array("icon"=>"editicon.gif");

      $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_VACNT, XOOPS_URL.'/user.php', $block['document']));
      $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_EACNT, XOOPS_URL.'/edituser.php', $block['document']));
      $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_NOTIF, XOOPS_URL.'/notifications.php', $block['document']));
      $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_LOUT, XOOPS_URL.'/user.php?op=logout', $block['document']));
  		$criteria = new CriteriaCompo(new Criteria('read_msg', 0));
  		$criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
      if ($pm_handler->getCount($criteria) > 0) {
        $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_INBOX." (".$pm_handler->getCount($criteria).")", XOOPS_URL.'/viewpmsg.php', $block['document_highlight']));
      } else {
        $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_INBOX, XOOPS_URL.'/viewpmsg.php', $block['document']));
      }
      if ($xoopsUser->isAdmin()) {
        $block['tree_root']->addItem(new HTML_TreeNodeXL(_MB_SYSTEM_ADMENU, XOOPS_URL.'/admin.php', $block['admin']));
      }
      $block['treemenuxl_user'] = new HTML_TreeMenu_DHTMLXL($block['tree_root'], array("images"=>XOOPS_URL."/modules/treemenuxl/images/".$options[0].""));
      $block['treemenuxl_user'] = $block['treemenuxl_user']->toHTML();
      return $block;
    }
    return false;
  }

  function b_edit_treemenuxl_user($options)
  {
    $form  = "\n\n<!-- begin TreemenuXL User -->\n";
    $form .= "<table style=\"border: 1px outset;\" cellspacing=\"3\" cellpadding=\"1\">\n";
    $form .= "<tr><td colspan=\"3\"align=\"center\"><b><i>"._TM_SHOWMENU2."</i></b></td></tr>\n";
    if ($options[0]=="explorer") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_EXPLORER."</td><td><input type=\"radio\" name=\"options[]\" value=\"explorer\"".$checked." /></td></tr>\n";
    if ($options[0]=="extra") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_EXTRA."</td><td><input type=\"radio\" name=\"options[]\" value=\"extra\"".$checked." /></td></tr>\n";
    if ($options[0]=="round") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_ROUND."</td><td><input type=\"radio\" name=\"options[]\" value=\"round\"".$checked." /></td></tr>\n";
    if ($options[0]=="small") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_SMALL."</td><td><input type=\"radio\" name=\"options[]\" value=\"small\"".$checked." /></td></tr>\n";
    if ($options[0]=="standard") {$checked = " checked";} else {$checked = "";}
    $form .= "<tr><td align=\"right\">"._TM_STANDARD."</td><td><input type=\"radio\" name=\"options[]\" value=\"standard\"".$checked." /></td></tr>\n";
    $form .= "</table>\n";
    $form .= "<!-- end TreemenuXL User in ".$options[0]." style -->\n\n";

    return $form;
  }

?>

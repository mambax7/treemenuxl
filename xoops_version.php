<?php
///  ------------------------------------------------------------------------ //
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

$modversion['name'] = _TM_NAME;
$modversion['version'] = '0.6';
$modversion['description'] = _TM_DESC;
$modversion['author'] = _TM_AUTHOR;
$modversion['credits'] = _TM_CREDITS;
$modversion['help'] = '';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 1;
$modversion['image'] = 'images/treemenuxl.png';
$modversion['dirname'] = 'treemenuxl';

// Blocks
$modversion['blocks'][1]['file'] = 'treemenuxl.php';
$modversion['blocks'][1]['name'] = _TM_BNAME1;
$modversion['blocks'][1]['description'] = _TM_DESC ;
$modversion['blocks'][1]['show_func'] = 'b_show_treemenuxl';
$modversion['blocks'][1]['options'] = 'explorer|yes|yes';
$modversion['blocks'][1]['edit_func'] = 'b_edit_treemenuxl';
$modversion['blocks'][1]['template'] = 'block_treemenuxl.html';

$modversion['blocks'][2]['file'] = 'treemenuxl.php';
$modversion['blocks'][2]['name'] = _TM_BNAME2;
$modversion['blocks'][2]['description'] = _TM_DESC ;
$modversion['blocks'][2]['show_func'] = 'b_show_treemenuxl_user';
$modversion['blocks'][2]['options'] = 'explorer';
$modversion['blocks'][2]['edit_func'] = 'b_edit_treemenuxl_user';
$modversion['blocks'][2]['template'] = 'block_treemenuxl_user.html';

// Menu
$modversion['hasMain'] = 0;
?>
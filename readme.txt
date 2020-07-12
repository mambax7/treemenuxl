Readme.txt TreeMenuXL for Xoops.

Install:

Just install this module as a normal Xoops module. If that is done, go to your blocks adminpage to
display your mainmenu in TreemenuXL style. Don't forget to look at the permissions!

Release notes:

0.1 initial release.
+ Based on some great scripts i found, the initial release of this Xoops mainmenu replacement.
+ Made it a CVS module for further development.
+ Added the standard options within a block according to Xoops:

* todo: show admin submenu's or not [ thanks to the author of dynamenu ]
* todo: let the admin change one of the five standard layouts.

0.2 beta release for testing...
+ Began working on a admin configuration page, because the treemenu on itself has quite
  some options. It uses 2 classes and 1 *.js/javascript file:
+ Admin configuration is there but within the standard block page of Xoops, so i don't dev. a special
  page for that. As of now, all the options will be set in the Xoops Block Adminpage. Result is that
  i don't need a admin/mysql or cache dir.
+ Dev. will not continue so version 0.2 for Xoops 1.3.x

0.3 beta release for testing with Xoops 2.0
+ Initially the mod. didn't work under Xoops 2.0, tried to solve this "issue" and succeeded.

0.4 beta release for testing with Xoops 2.0
+ Toggle normal menulinks with adminlinks or no adminlinks. Just to reduce the html in your Xoops pages.

[note] This release will work fine if you use Xoops 2.0 rc2 but if you update the website from CVS then
       TreemenuXL will not work, as of 10-03-03. I used the mainmenu code from Xoops but if that
       changes, i have to change the code also.

0.5 beta release for testing with Xoops 2.0
+ A complete rewrite of the Xoops code used in TreemenuXL was needed. The 0.4 version of Tree...didn't
  work with the last CVS Xoops [10-03-03]
- Toggle between adminlinks or not in the mainmenu is not yet implemented due to the change of Xoops code.

0.6 release for Xoops 2.0.x

+ show [all] sublinks or show [active] links in de mainmenu. [Artur Oliveira]
+ show adminlinks of not with new xoops code. [Artur Oliveira]
+ use original css/browser detection files, for now disabled due some problems. [Artur Oliveira]
  If i test using TreeMenuXL it looks ok with IE5+ and Mozilla 1.2x In Opera 7.0b2577 the menu
  shows but totally expanded, so that needs some work. note: opera without java, could be the diff.

* todo: show an overview of directory's and displaying images. See Xoops Block Admin.
* todo: control the image size.
* todo: toggle between expanded/collapsed.

Credits:

The credits go to the original authors because i based TreemenuXL for Xoops on existing files and ideas.

1. HTML_TreeMenuXL 2.0.2 by Chip Chapin <cchapin@chipchapin.com> - http://www.chipchapin.com
2. TreeMenu 1.1.0 by Richard Heyes <richard@phpguru.org> and Harald Radi <harald.radi@nme.at>
3. Dynamenu 0.5 by Np. v/d Spek - http://www.lumensoft.nl [ TreemenuXL v0.2 ]
4. TreemenuXL v0.3 and up, is based on Xoops code.
5. Extra credits for Artur Oliveira [ aka _vlad_ ] <artur.oliveira@gmail.com> for the new adminlinks.

---------------------------------------------------------
|                  eyeOS User Manual                    |
|                    Version 1.0.0                      |
|                                                       |
|                                                       |
|Please send changes of this document to team@eyeos.org |
|    Licensed under GNU Free Documentation License      |
|                                                       |
---------------------------------------------------------

-----------------------Summary---------------------------

Introduction

Requirements
   -Server
   -Client

Installation Instructions

Using eyeOS
   -Introduction to eyeOS Desktop
   -Window Operations
   -System tray
   -Installing and removing applications
       -Installation
       -Deletion

Getting support

Helping the project

---------------------------------------------------------

Introduction
------------

In first place, welcome to eyeOS. You're about to discover a new work and
organization method: A completely free (Open Source) desktop system running
from your browser.

The purpose of this User Manual is to provide documentation to all new users
to eyeOS for installing it, using it and solving problems with the system.
If you are a programmer and would like to contribute to eyeOS project, you
may want to see the Developer Manual.



Requirements
------------


----Server----

The main requirement for a new eyeOS 0.9.x Installation is a PHP compatible
web server installed locally or with a web hosting company. Our recommendation
is to use a Unix/Linux server with Apache Web Server version 1.3.x or 2.x and
PHP version 4.3.x or 5.0.x.

eyeOS is primarily file based and requires no database for its operation. You
will however need the capability of uploading files and directories to the
webspace and to be able to change folder permissions.


----Client----

Your browser needs to be standards-compliant and support CSS. This includes
the common modern browsers: Internet Explorer, Firefox, Safari, Opera... It is
necessary to enable your browser to accept cookies from the eyeOS server.



Installation Instructions
-------------------------

First download the latest version of eyeOS from http://eyeOS.org/downloads .
Since eyeOS comes packed in .tar.gz format, you will need to uncompress it
using "tar -zxvf eyeOS-0.x.y.tar.gz" in Unix systems or any uncompress program
like WinZip for Windows systems. In other systems, use the appropriate
uncompress program.

Once uncompressed, you need to upload the uncompressed eyeOS directory to your
webspace using FTP or similar transfer. Change the name of the directory from
"eyeOS-0.x.y" to your desired name, since it will be part of your eyeOS URL.
If you wish to have eyeOS installed in your root dir, you only need to upload
the files and directories inside the eyeOS-0.x.y directory.

When the upload finishes, you need to change permissions on three directories
to allow eyeOS write, read and execute them (full permissions). Many FTP
programs provide means of changing file and folder permissions, you only have
to look for a menu item called "CHMOD", "Permission" or "Change Permissions".
The directories which need to have thier permissions changed to 777 are:

etc/

Once completed, you only have to run your new installed eyeOS and follow the
screen instructions to end the installation.



Using eyeOS
-----------


----Introduction to eyeOS Desktop----

The default desktop is composed by your chosen wallpaper and the applications
dock, where you will see your desired applications. Moving the mouse over the
icons, the name of each app will appear, and clicking on the icon the app will
be launched.

Once launched an application, it will appear as a new eyeOS window in your
desktop. The other apps you could be running will pass to uppercase and the
opened app will be on the top of all desktop windows.


----Window Operations----

When open, application windows can be dragged, resized and maximized. Some
operations may be restricted by the applications themselves.

To "drag" a window to a more convenient position on the desktop, click and
drag in the title or bottom bars of the application window.

The window may be also be "resized" if the resize icon appears in the bottom
right corner of the window. Click and drag this icon to resize the window.

To bring a window to the top click on any exposed part or click on the
hightlighted application icon.

The "maximize" button (next to the clos button) can be used for resize the
window to the full screen.


----System tray----

In the bottom right corner of desktop you will find the system tray. There you
can find the Clock, the Exit button and the Recycle Bin. The recycle bin is a
repository for all files you delete using the eyeHome (the file manager).
Files saved here can be recovered by running the recycle bin application by
clicking on its icon. If the recycle bin icon shows a coloured recycle symbol,
then the recycle bin contains files which may be recovered or permantently
discarded from the recycle bin application.


----Installing and removing applications----

--------Installation--------

eyeOS new applications come packed in ".eyeApp.tar.gz" files, so the first you
will need to do to install a new app is download the package. You can find
lots of apps for eyeOS (eyeApps) in http://eyeapps.org.

The process of installation is automatic, so the only thing you will need to
do for installing a package is open the Application Manager and select the
".eyeApp.tar.gz" package from your PC. The system will uncompress it, and
install it for your current user, or for the global system (this option only
appears if you're SuperUser).

--------Deletion--------

The process for deleting an app is easy too: You only have to click on the
delete icon (the orange cross) next to the application you want to remove and
click to the Accept button when a prompt asks you if you are sure to remove
that application.



Getting support
---------------

If you have any questions or suggestions, you can use the eyeOS public forums,
available at http://eyeos.org/forums. You can also contact us at team@eyeos.org.



Helping the project
-------------------

eyeOS is a GPL project, and many people have made their contributions. We aim
to create a new method of working on the Internet. If you can help us
programming, designing, testing or otherwise, we would be glad to welcome
you to our community. Contributions to the project are also possible via
public donations. You can read more information about donations at
http://eyeos.org/donations .

Thanks!

http://eyeOS.org
team@eyeos.org

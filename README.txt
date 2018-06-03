CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Recommended modules
* Installation
* Configuration
* Maintainers


Introduction
------------

The **Advanced help** module provides a framework that allows module
and theme developers integrate help texts in a Drupal site.

For more documentation, please visit: /admin/help/ah/advanced_help
after enabling the module.

Requirements
------------

This module has no required dependencies outside of Drupal core.


Recommended modules
-------------------

Advanced help hint:
  https://www.drupal.org/project/advanced_help_hint
  If Advanced help is not enabled, this module will generate a hint
  string that can be used in the project's hook_help to hint that
  Advanced help should be
  enabled.


Installation
------------

Install the Advanced Help module as you would normally install a
contributed Drupal module. See
https://drupal.org/documentation/install/modules-themes/modules-7 for
further information.


Configuration
-------------

By itself, this module doesn't do much. The Advanced help assists
other modules and themes in showing help texts. Nothing will show up
until you enable at least one other module that makes use of the
Advanced help framework or comes with a file named README.md or
README.txt.


Maintainers
-----------

merlinofchaos (52 commits, original creator)
redndahead (8 commits)
dmitrig01 (3 commits)
amitgoyal  (5 commits)
gisle (current maintainer, D7)
gnuget (current maintainer, D8)

This project has been sponsored by:Hannemyr Nye Medier AS

; Results site make file

; This is the base make file that includes other make files depending on the
; project or installation context.
;
; Use it with the following command:
;
; drush make results.make <target directory>


; Core version
; The make file always begins by specifying the core version of Drupal for
; which each package must be compatible.
core = 8.x


; API version
; The make file must specify which Drush Make API version it uses.
api = 2


; Drupal core
; Specific version
;projects[drupal][version] = 8.0.x

; Head from git
projects[drupal][download][type] = git
projects[drupal][download][url] = http://git.drupal.org/project/drupal.git
projects[drupal][download][branch] = 8.0.x

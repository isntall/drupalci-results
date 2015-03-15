; Results site make file

; Core version
; The make file always begins by specifying the core version of Drupal for
; which each package must be compatible.
core = 8.x

; API version
; The make file must specify which Drush Make API version it uses.
api = 2

; Drupal core.
projects[drupal][download][type] = git
projects[drupal][download][url] = http://git.drupal.org/project/drupal.git
projects[drupal][download][tag] = 8.0.0-beta6

; Contrib modules.

projects[page_manager][version] = "1.0-alpha2"
projects[restui][version] = "1.x-dev"
projects[rest_api_doc][version] = "1.0-alpha3"

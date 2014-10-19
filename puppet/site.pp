# The node definition.

node default {

  include yum::repo::remi_php56

  ##
  # PHP.
  ##

  package {[
    'php-common',
    'php-cli',
    'nmap',
  ]:
    ensure => 'latest',
  }

  ##
  # Apache.
  ##

  class { 'apache':
    default_vhost => false,
    mpm_module    => 'prefork',
  }
  apache::listen { '80': }
  include apache::mod::rewrite
  include apache::mod::php

  apache::vhost { $fqdn:
    docroot          => '/var/www/api/current/public',
    manage_docroot   => false,
    priority         => '25',
    override         => [ 'ALL' ],
  }

}

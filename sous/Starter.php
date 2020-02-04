<?php

namespace Sous;

use Composer\Script\CommandEvent; #the event is different !
use DrupalFinder\DrupalFinder;

/**
 * Provides static functions for composer script events. See also
 * core/lib/Drupal/Composer/Composer.php, which contains similar
 * scripts needed by projects that include drupal/core. Scripts that
 * are only needed by drupal/drupal go here.
 *
 * @see https://getcomposer.org/doc/articles/scripts.md
 */
class Starter {

public static function installTheme(CommandEvent $event) {
  // New DrupalFinder to get the Composer root path.
  $drupalFinder = new DrupalFinder();
  $drupalFinder->locateRoot(getcwd());
  $composerRoot = str_replace('-', '_', strtolower(basename($drupalFinder->getComposerRoot())));
  // Execute the Emulsify theme build based on composer create path.
  shell_exec ("cd web/themes/contrib/emulsify-design-system/ && php emulsify.php $composerRoot");
  shell_exec ("cd web/themes/contrib/emulsify-design-system/ && npm install");
  }
}

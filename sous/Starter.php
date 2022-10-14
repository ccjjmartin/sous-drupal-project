<?php

namespace Sous;

use DrupalFinder\DrupalFinder;
use Symfony\Component\Yaml\Yaml;

/**
 * Provides static functions for composer script events. See also
 * core/lib/Drupal/Composer/Composer.php, which contains similar
 * scripts needed by projects that include drupal/core. Scripts that
 * are only needed by drupal/drupal go here.
 *
 * @see https://getcomposer.org/doc/articles/scripts.md
 */
class Starter {

  /**
   * Install emuslify.
   */
  public static function installTheme() {
    // Install node dependencies which include EmulsifyCLI for commands below.
    shell_exec('[ -s "$HOME/.nvm/nvm.sh" ] && . "$HOME/.nvm/nvm.sh" && nvm install lts/gallium && nvm use && npm ci');
    // Execute the Emulsify theme build based on composer create path.
    shell_exec("[ -s \"\$HOME/.nvm/nvm.sh\" ] && . \"\$HOME/.nvm/nvm.sh\" && nvm install lts/gallium && nvm use && npx emulsify init public --platform drupal");
    shell_exec("[ -s \"\$HOME/.nvm/nvm.sh\" ] && . \"\$HOME/.nvm/nvm.sh\" && nvm install lts/gallium && nvm use && cd web/themes/custom/public/ && npx emulsify system install --repository https://github.com/emulsify-ds/compound.git --checkout 1.6.1");
    // Generate  system.theme.yml and append new theme to install.
    //$system_theme_yml = [
    //  "default" => "public",
    //  "admin" => "gin",
    //];
    // $yaml = Yaml::dump($system_theme_yml);
    // file_put_contents('web/profiles/contrib/sous/config/install/system.theme.yml', $yaml);
    // file_put_contents('web/profiles/contrib/sous/sous.info.yml', '  - ' . $composerRoot . PHP_EOL, FILE_APPEND | LOCK_EX);
    // Remove contrib theme after theme generation.
    // shell_exec("rm -rf web/themes/contrib/emulsify-drupal/");
    // shell_exec("sed -i '' 's/sous-project/$composerRoot/g' .lando.yml");
  }

  /**
   * Install modules.
   */
  public static function installModules() {
    // Install required modules.
    shell_exec("lando drush en media,node,views,field,taxonomy,user -y");

    // Install core modules.
    shell_exec("lando drush en automated_cron,block,block_content,breakpoint,ckeditor,config,contextual,dynamic_page_cache,field_ui,filter,inline_form_errors,menu_link_content,menu_ui,options,path,responsive_image,shortcut,system,editor,toolbar,update,views_ui -y");

    // Install contrib modules.
    shell_exec("lando drush en admin_toolbar,allowed_formats,ckeditor_browser_context_menu,components,crop,ctools,dropzonejs,dropzonejs_eb_widget,inline_entity_form,easy_breadcrumb,entity_browser,entity_browser_entity_form,entityBrowser_enhanced,entity_embed,entity_usage,field_group,focal_point,google_tag,improve_line_breaks_filter -y");
    shell_exec("lando drush en libraries,linkit,login_history,menu_block,metatag,metatag_open_graph,metatag_twitter_cards,paragraphs,paragraphs_collapsible,paragraphs_features,paragraphs_ee,pathauto,redirect,role_delegation,taxonomy_manager,token,twig_tweak,emulsify_twig -y");
  }

}

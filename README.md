# d8-config-translations
Sample Drupal8 module with translatable configuration, which contains: 

- **src/Form/sampleCfgHomepageForm.php** - configuration form, allows to define 3 links (titles+urls) 
- **src/Plugin/Block/sampleCfgHomepageBlock.php** - Custom block, to display links 
- **config/install/sample_cfg.config.yml** - default configuration values and language
- **config/schema/sample_cfg.schema.yml** - configuration schema/metadata 
- **sample_cfg.config_translation.yml** - exposes configuration object for config translation module 
- **sample_cfg.links.task.yml** - settings tab displayed in configuration form, thanks to that "Translate" tab is being added automatically 
- **sample_cfg.permissions.yml** - just a custom permission 
- **sample_cfg.routing.yml** - route for configuration form 

More comments can be found inside of module files, 
developed and tested with 8.2.5 version 


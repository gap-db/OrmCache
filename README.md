Gap ORM Cache
===============
Cache for Gap Orm, available "memcache" driver

REQUIREMENTS
------------
PHP > 5.4.0

INSTALLATION
------------
If you're using [Composer](http://getcomposer.org/) for your project's dependencies, add the following to your "composer.json":
```
"require": {
    "gap-db/OrmCache": "1.0.*"
}
```

Update Modules Config List - safan-framework-standard/application/Settings/modules.config.php
```
<?php
return array(
    // Safan Framework default modules route
    'Safan' => 'vendor/safan-lab/safan/Safan',
    'SafanResponse' => 'vendor/safan-lab/safan/SafanResponse',
    // Write created or installed modules route here ... e.g. 'FirstModule' => 'application/Modules/FirstModule'
    'GapOrm'      => 'vendor/gap-db/orm/GapOrm',
    'GapOrmCache' => 'vendor/gap-db/OrmCache/GapOrmCache',
);
```

Add Configuration - safan-framework-standard/application/Settings/main.config.php
```
<?php
'init' => array(
    'gapOrmCache' => array(
        'class'  => 'GapOrmCache\GapOrmCache',
        'method' => 'init',
        'params' => array(
            'prefix' => 'prefix',
            'driver' => 'memcache'
        )
    ),
)
```


# Nette Propel 2 adapter

## installation

### composer.json

```
"repositories": [{
    "url": "https://github.com/jzaplet/nette-asset-loader",
    "type": "git"
},{
    "url": "https://github.com/jzaplet/nette-propel",
    "type": "git"
}],

"minimum-stability": "alpha", // or require propel aplha

"require": {
    "jzaplet/nette-propel": "@dev"
}
```

### create propel.local.neon in app/config/
```
database_name:
    adapter: mysql
    host: 127.0.0.1
    user: root
    password:
```

### add extension in main app/config/???.neon
```
extensions:
    - NettePropel\DI\NettePropelExtension
```

### create shortcut for bin/npropel
`ln -s vendor/bin/npropel propel`

### and in terminal use
`./propel`
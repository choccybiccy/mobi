# .mobi
Handle .mobi files with ease.

## Introduction
This package was born out of frustration. There didn't seem to be a
decent open source .mobi reader out there for PHP, so I wanted to 
create my own to give back to the community.

## Installation
```
$ composer require choccybiccy/mobi
```

## Usage
### Reading .mobi files
```
$mobi = new Mobi\Reader('MyBook.mobi');
```

## Testing
```
$ ./vendor/bin/phpunit
```

## Thanks
* http://wiki.mobileread.com/wiki/MOBI


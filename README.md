# ZabGraphs
> Based on [Graphtrees](https://share.zabbix.com/zabbix-tools-and-utilities/web-addons/graphtree-for-zabbix) for Zabbix, permit easy access to all graphs of a host, hosts or host group.

![](https://repository-images.githubusercontent.com/189693207/0b4ecb00-85ec-11e9-8c44-8aa5c1fb7d94)

## Installation

1 - Copy zabgraphs folder to Zabbix folder (/usr/share/zabbix);

2 - Copy config.php.sample to config.php;

3 - Edit config.php with your server settings;

4 - Access URL http://your_zabbix_server/zabbix/zabgraphs;


To add a menu item for ZabGraphs see README.txt file in menu folder.


Zabbix API Needs php-posix:

In debian/ubuntu is in php-common package.
yum install php-process - redhat/centos
zypper install php-posix - OpenSuse


## Contributing

1. Fork it (<https://github.com/yourname/yourproject/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
5. Create a new Pull Request

<!-- Markdown link & img dfn's -->
[npm-image]: https://img.shields.io/npm/v/datadog-metrics.svg?style=flat-square
[npm-url]: https://npmjs.org/package/datadog-metrics
[npm-downloads]: https://img.shields.io/npm/dm/datadog-metrics.svg?style=flat-square
[travis-image]: https://img.shields.io/travis/dbader/node-datadog-metrics/master.svg?style=flat-square
[travis-url]: https://travis-ci.org/dbader/node-datadog-metrics
[wiki]: https://github.com/yourname/yourproject/wiki

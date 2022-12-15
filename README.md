# yii2-dependency-finder
Extension for finding horizontal dependencies of Yii2 modules

### How to install to Yii2 project
```
composer require smoren/yii2-dependency-finder
```

### Usage

```php
use Smoren\Yii2\DependencyFinder\Components\ProjectDependencyFinder;
use Smoren\Yii2\DependencyFinder\Writers\CsvWriter;
use Smoren\Yii2\DependencyFinder\Writers\TxtWriter;
use Smoren\Yii2\DependencyFinder\Structs\Path;

$dependencyFinder = new ProjectDependencyFinder(new Path(dirname(__DIR__)));
$dependencyCollection = $dependencyFinder->find();

print_r($dependencyCollection->getSummary());

$writer = new CsvWriter(new Path(dirname(__DIR__), 'logs/dependencies.csv'));
$writer->write($dependencyCollection);

$writer = new TxtWriter(new Path(dirname(__DIR__), 'logs/dependencies.txt'));
$writer->write($dependencyCollection);
```

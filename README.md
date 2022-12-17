# yii2-dependency-finder
Extension for finding horizontal dependencies of Yii2 modules

### How to install to Yii2 project
```
composer require smoren/yii2-dependency-finder
```

### Usage

```php
use Smoren\Yii2\DependencyFinder\Finders\ProjectDependencyFinder;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Smoren\Yii2\DependencyFinder\Writers\ShortTxtWriter;
use Smoren\Yii2\DependencyFinder\Writers\ShortTxtWriter;
use Smoren\Yii2\DependencyFinder\Writers\DetailedTxtWriter;
use Smoren\Yii2\DependencyFinder\Writers\CsvWriter;

$dependencyFinder = new ProjectDependencyFinder(new Path(dirname(__DIR__)));
$dependencyCollection = $dependencyFinder->find();

print_r($dependencyCollection->getSummary());

$writer = new ShortTxtWriter(new Path(dirname(__DIR__), 'logs/dependencies_short.txt'));
$writer->write($dependencyCollection);

$writer = new DetailedTxtWriter(new Path(dirname(__DIR__), 'logs/dependencies_detailed.txt'));
$writer->write($dependencyCollection);

$writer = new CsvWriter(new Path(dirname(__DIR__), 'logs/dependencies.csv'));
$writer->write($dependencyCollection);
```

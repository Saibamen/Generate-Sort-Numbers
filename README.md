[![Travis Build Status](https://travis-ci.org/Saibamen/Generate-Sort-Numbers.svg)](https://travis-ci.org/Saibamen/Generate-Sort-Numbers)
[![CircleCI Build Status](https://circleci.com/gh/Saibamen/Generate-Sort-Numbers.svg?style=shield)](https://circleci.com/gh/Saibamen/Generate-Sort-Numbers)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Saibamen/Generate-Sort-Numbers/badges/quality-score.png)](https://scrutinizer-ci.com/g/Saibamen/Generate-Sort-Numbers/)
[![Code Climate](https://codeclimate.com/github/Saibamen/Generate-Sort-Numbers/badges/gpa.svg)](https://codeclimate.com/github/Saibamen/Generate-Sort-Numbers)
[![StyleCI](https://styleci.io/repos/104583437/shield)](https://styleci.io/repos/104583437)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/26f85851-cba3-4d7d-a4f5-892faf8258c1/mini.png)](https://insight.sensiolabs.com/projects/26f85851-cba3-4d7d-a4f5-892faf8258c1)

# Generate and sort numbers in PHP

PHP console app for [Fingo](http://www.fingo.pl/).

Documentation for programmers: [here](https://saibamen.github.io/Generate-Sort-Numbers/)

## Requirements

* PHP >= 5.3.3
* [Composer](https://getcomposer.org/) if you want to generate documentation

## Usage

### Generating numbers

Run generate script and follow instructions:

```
php generate
```

Options:

* **--min:** minimum allowed number
* **--max:** maximum allowed number
* **--decimal:** number of decimal places
* **--size:** maximum file size eg. 5B, 5KB, 5MB, 5GB
* **--output:** output filename (without extension)
* **--ext:** file extension
* **--delimiter:** delimiter for numbers
* **--debug:** prints dev informations
* **--testing:** doesn't print progress when generating

### Sorting numbers

Run sort script and follow instructions:

```
php sort
```

Options:

* **--input:** input filename (without extension)
* **--output:** output filename (without extension)
* **--ext:** file extension
* **--delimiter:** delimiter for numbers
* **--debug:** prints dev informations

### Generating documentation

Update Composer and install latest [phpDocumentor](https://www.phpdoc.org/) from composer.json:

```
composer self-update
composer update
```

Generate documentation:

Under Linux / MacOSX:
```
vendor/bin/phpdoc -d ./ -f generate -f sort -t ./docs --ignore "vendor/"
```

Under Windows:
```
vendor\bin\phpdoc.bat -d ./ -f generate -f sort -t ./docs --ignore "vendor/"
```

# WPU Cached

Simple helpers to help you cache anything.

## Get cached wpdb values

### Column

```php
$ids = wpu_cached__wpdb_get('col', "SELECT id FROM mytable");
```

### Results

```php
$ids = wpu_cached__wpdb_get('results', "SELECT * FROM mytable");
```


# Test Plugin for DIC (Pimple) Integration

#### Installation process
Just `clone` the project in you `wp-content/plugins` directory and then run
`composer install` and `composer dump-autoload`

#### Create a product
Use this function to create a new product
```
rtcamp_di()->product->create(
    array(
        'title' => 'Shirt',
        'description' => 'Lorem ipsum test',
        'price' => '23.33',
        'sku' => 'shirt-21',
        'type' => 'simple'
    )
);
```

#### Displaying all product
```
rtcamp_di()->product->all();
```

#### Get a single product
```
rtcamp_di()->product->get(3); // where 3 is product id
```

#### For render HTML part just use the shortcode
```
[rt-products]
```

# Author
Sabbir Ahmed
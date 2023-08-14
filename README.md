# php-utils
PHP Language utility codes.

### utils\ArrayUtil::digSet()
- Set value by specified index(es).
- Index(es) are provided as method parameter(s).
- Usage
    - `ArrayUtil::digSet($input, 'test', 'foo', 'bar', 3);` is same as `$input['test']['foo']['bar'] = 3;`
        - If intermediate indexes one/or more of test, foo, bar are undefined the indexes will be created.
    - `ArrayUtil::digSetDn()` is same as `ArrayUtil::digSet()` except index parameters is arrray notation string.

# php-utils
PHP Language utility codes.

## Usage
### Run unit test
- Install docker environment and make command if you have not.
- Just execute `make` to build docker container and execute unit-test.

### Other cli usage
- `make unit-test` runs just unit test.
- `make destroy` remove the docker container and image.

## Reference
### flipfrog\utils\ArrayUtil
#### digSet()
- Set value by specified index(es).
- Index(es) are provided as method parameter(s).
- Usage
- `digSet($input, 'test', 'foo', 'bar', 3);` is same as `$input['test']['foo']['bar'] = 3;`
- If intermediate indexes one/or more of test, foo, bar are undefined the missing indexes will be created.
#### digSetDn()
- `digSetDn()` is same as `digSet()` except index parameters is array dot notation string.
- for example `digSet($input, 'test', 'foo', 'bar', 3);` is equivalent to `digSetDn($input, 'test.foo.bar', 3);`

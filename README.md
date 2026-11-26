# Locale Detector

Detect a locale from a Symfony HTTP Foundation request or a PSR-7
`ServerRequestInterface`, including requests from `bytic/http`.

```sh
composer require bytic/locale-detector
```

```php
use Nip\Locale\Detector\Detector;

$locale = Detector::detect($request); // string or null
```

By default, the detector checks the `lang` and `language` query parameters,
then the `nip_locale` cookie. It uses the parsed PSR-7 query and cookie
parameters when given a server request. To also check `Accept-Language`,
specify the desired stage order:

```php
$locale = Detector::detect($request, [], ['query', 'cookie', 'acceptlanguage']);
```

The optional second argument lists supported locales. A detected locale not
in that list causes an `InvalidLocale` exception; an empty list accepts any
locale. The first detected locale wins.

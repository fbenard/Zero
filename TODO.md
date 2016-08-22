- Use classes for exceptions instead of constants
- Write unit tests for every part of code
- Get rid redis dependencies, whenever possible (redis, lightncandy, guzzle)

	"monolog/monolog": "*",
	"guzzlehttp/guzzle": "5.3",
	"predis/predis": "1.0.0",
	"zordius/lightncandy": "v0.89"

- Shortcut functions should be declared differently
- Implement zero-cli to assist dev (create route, etc)
- Write a documentation with global architecture, classes and methods, tutorials
- Do dependency injection (e.g. Redis driver), rely more often on interfaces
- Get rid of StringHelper
- FileHelper and HttpHelper could be independent components
- BufferManager could rely on IBufferHandler to start, stop and clean output buffer
- Events should be classes? Their code should be defined inside the class?
- Add AbstractEvent::isPost / isPre (declared in constructor 2nd argument)
- Constants should be declared in JSON files
- Split controller management code (factory, run)
- Loading of prefs, routes, constants should be moved to a separate class
- ErrorRenderer is a bit fat, move GUI/CLI/HTML/JSON code outside
- Should migration manager be part of Zero?
- RouteManager is too fat
- Templates should be used by zero-cli
- CacheManager, BootManager and ServiceManager are forced dependencies of the app
- Also they're not available via service('manager/*')
- Improve how cache is loaded / saved

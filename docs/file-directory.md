# CI4 LMS Directory Structure

```

. lms2
	|-- app 							- Application directory
	|  	|-- Config				- Stores the configuration files
	|  	|-- Controllers		- Controllers determine the program flow
	|  	|-- Database			- Stores the database migrations and seeds files
	|  	|-- Filters				- Stores filter classes that can run before and after controller
	|  	|-- Helpers				- Helpers store collections of standalone functions
	|  	|-- Language			- Multiple language support reads the language strings from here
	|  	|-- Libraries			- Useful classes that don't fit in another category
	|  	|-- Models				- Models work with the database to represent the business entities
	|  	|-- ThirdParty		- ThirdParty libraries that can be used in application
	|  	|-- Views					-	Views make up the HTML that is displayed to the client	│		
	|		|		 |-- assets
	|		|		 |		|-- css
	|		| 	 |		|-- images
	|		| 	 |		|-- js
	|		| 	 |		|-- lib
	|		|		 |-- pages
	|		|		 |		|--	admin
	|		|		 |		|-- ...
	|		|		 |-- errors
	|		|--	 |-- templates	- head.php, nav.php, footer.php, content.php
	|-- public
	|--	system
	|--	tests
	|--	writable		
	|-- ...
	
```
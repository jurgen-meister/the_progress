#EL PROGRESO 

Repository for IMEXPORT project

##Installation of the plugins


###Submodule

	$ cd /imexport
	$ git submodule init
	$ git submodule update 
	
	$ cd /imexport/app/Plugin/TwitterBootstrap
	$ git submodule update --init
	
###After baking instructions

	After baking each model you have to edit 
	admin/app/Controller/[modelname]controller.ctp
	
	$layout = 'bootstrap' 
	
	for 
	
	$layout = 'default'
	

###Objetos que no se copian desde el repositorio de GitHub para un proyecto CakePHP:

	-El archivo core.php en el directorio app\Config (hay que ponerlo manualmente)

	-El archivo de configuración de base de datos database.php aparece como 'database.php.default' y hay que configurarlo según la configuración local en el directorio app\Config

	-El directorio tmp en la carpeta app no se copia (hay que ponerla a mano)

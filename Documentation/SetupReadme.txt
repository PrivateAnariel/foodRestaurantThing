Setup pour symfony2, PHP et MongoDB avec WAMP Server 2 sur windows 8


--Installer WAMP--
go to http://www.wampserver.com/en/#download-wrapper
Downloader la bonne vesrion (x64 ou x32 selon la version de windows)

**Important ther toujours donner l'acces si windows demande la permission**
Demarrer l'installation
Next > Selectionner l'option "I accept the agreement" > Next >
Choisir le dossier d'instllation. Il est recommender de le mettre directement sur le disque (par defaut, "c:\wamp") > 
next > Create Desktop Icon/quick launch icon au choix > next > 
Install

Donner les permissions de reseau desire (recommande de donner tous les permissions)
inserer votre adresse dans le champs Email, de facon a pouvoir tester les fonctions de messagerie.

verifier l<installation en visitant l'adresse "localhost" sur un browser

**OPTIONEL**
Si le serveur WAMP affiche comme hors ligne, il est possible que plusieurs logiciels interferent avec le port de WAMP
Par defaut, skype et apache sont sur le port 80, ce qui cause des problemes pour WAMP.

Ouvrir le fichier de httpd.conf de Apache dans notepad
le fichier se trouve dans "%wampRoot%\bin\apache\apache2.4.9\conf"

Remplacer tous les instances de ":80" par ":xxx" ou xxx est un port non utilise
Ceci est facile en apuyamd sur ctrl+h, find ":80" replace by ":xxx"
les ports a 5 chiffres sont rarement utilise (ex :10001)



--Ajouter PHP au path windows--
Avant de commencer, verifier le path de PHP.
le path devraid etre "%wampRoot%\bin\php\php5.x.y" ou x et y sont votre version de php
Selon les instructions d'installation precedentes, le path devrait etre "c:\wamp\bin\php\php5.5.12"

aller a "Control Panel\System and Security\System" (ou l'equivalent francais)
advanced system settings > onglet "advanced" > Envrionment Variables
creer la variable "PHP_HOME" avec le path de php comme valeur ("%wampRoot%\bin\php\php5.x.y")
Editer la variable PATH et y ajouter ";%PHP_HOME%" -A LA FIN-
Le ";" est important pour differentier les differents path.
Appuyer sor ok pour enregistrer les modifications

Tester en ouvrant le command promp (cmd.exe) et utiliser la commande "php -v"
Le cmd devrait afficher la version de php installee.



--Setup MundoDB--
aller sur http://www.mongodb.org/downloads 
telecharger la version approprie (32bit ou 64bit) **EN ZIP**
Creer le dossier "%wampRoot%\bin\mongodb\" ("%wampRoot%" refere au dossier d'installation de WAMP)
extraire l'archive zip dans le dossier
le nouveau dossier devrais ressembler a "c:\wamp\bin\mongodb\mongodb-win32-x86_64-2008plus-2.6.7"
dans le nouveau dossier, ajouter les dossiers suivants:

\data
\data\db
\logs
\conf

dans le dossier conf, ajouter un ficher mongodb.conf avec le contenu suivant:

# mongodb.conf

# data lives here
dbpath=%wampRoot%\bin\mongodb\mongodb-win32[...]\data\db

# where to log
logpath=%wampRoot%\bin\mongodb\mongodb-win32[...]\logs\mongodb.log
logappend=true

# only run on localhost for development
bind_ip = 127.0.0.1                                                             

port = 27017
rest = true

***Fin du contenu***
S'assurer de bien remplacer les path pour ceux des dossiers crees plus tot
ouvrir le cmd en mode administrateur et effectuer les deux commandes suivantes:

	cd C:\wamp\bin\mongodb\mongodb-win32-x86_64-2008plus-2.6.7\bin
	
	mongod.exe --install --config %wampRoot%\bin\mongodb\mongodb-win32[...]\conf\mongodb.conf --logpath %wampRoot%\bin\mongodb\mongodb-win32[...]\logs\mongodb.log

Encore une fois s<assurer que les path sont bien remplaces
executer Services.msi (windows key + r > "services.msi")
defiler jusqua MongoDb, en faisant un click droit > proprietes, on peut choisir le type de demarrage. 
Automatique demarre MongoDb a louverture de l'ordinateur, manuel requiert un demarage manuel a chaque utilisation.

L'installation peu etre verifie dans le fichier %wampRoot%\bin\mongodb\mongodb-win32[...]\logs\mongodb.log

--Ajoute MongoDb au path--
Avant de commencer, verifier le path de PHP.
le path devraid etre "%wampRoot%\bin\php\php5.x.y" ou x et y sont votre version de php
Selon les instructions d'installation precedentes, le path devrait etre "c:\wamp\bin\php\php5.5.12"

aller a "Control Panel\System and Security\System" (ou l'equivalent francais)
advanced system settings > onglet "advanced" > Envrionment Variables
creer la variable "MONGO_HOME" avec le path de mongo comme valeur ("%wampRoot%\bin\mongodb\mongodb-win32[...]\bin")
Editer la variable PATH et y ajouter ";%MONGO_HOME%" -A LA FIN-
Le ";" est important pour differentier les differents path.
Appuyer sor ok pour enregistrer les modifications

Tester en ouvrant le command promp (cmd.exe) et utiliser la commande "mongo -help"
Le cmd devrait afficher la version de MongoDb installee ainsi qu<une liste de commandes.


--Ajouter les DLL de MongoDb--
telecharger https://s3.amazonaws.com/drivers.mongodb.org/php/php_mongo-1.4.5.zip
extraire le fichier dll approprie selon la version de php installe (devrait etre php_mongo-1.[a.b]-5.[x]-vc9.dll ou a et b ne sont pas important)
mettre le fichier dans le dossier %wampRoot%\bin\php\php5.x.y\ext
renommer le fichier "php_mungodb.dll"
ouvrir le fichier %wampRoot%\bin\php\php5.[x.y]\php.ini
ajouter la ligne "extension=php_mongo.dll" au fichier php.ini



--installer Composer--
telecharger et ouvrir
https://getcomposer.org/Composer-Setup.exe

suivre les instructions (php.exe est dans %wampRoot%/bin/php/php5.x.y)


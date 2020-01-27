Created a Simple login page validation:
-------------------------------------- 
PHP Framework : "Slim Framework"	 ~~ composer require slim/slim "3.0"

Template      : "Twig Template Engine"   ~~ composer require slim/twig-view

CSS 	      : "Bootstrap Framework"

DB Model      : "Laravel Eloquent ORM"   ~~ composer require illuminate/database

Database Table - 'users', 'pixel'

CREATE TABLE `users` (
   `id` int(7) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `email` varchar(255) NOT NULL,
   `password` varchar(255) NOT NULL,
   `created_at` datetime DEFAULT NULL,
   `updated_at` datetime DEFAULT NULL,
   `verified` int(11) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1CREATE TABLE `users` (
   `id` int(7) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `email` varchar(255) NOT NULL,
   `password` varchar(255) NOT NULL,
   `created_at` datetime DEFAULT NULL,
   `updated_at` datetime DEFAULT NULL,
   `verified` int(11) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1
 
 CREATE TABLE `pixel` (
   `id` int(11) NOT NULL,
   `pixelType` varchar(45) DEFAULT NULL,
   `userId` int(11) DEFAULT NULL,
   `occuredOn` int(11) DEFAULT NULL,
   `portalId` int(11) DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `userId_idx` (`userId`)
 ) ENGINE=MyISAM DEFAULT CHARSET=latin1CREATE TABLE `pixel` (
   `id` int(11) NOT NULL,
   `pixelType` varchar(45) DEFAULT NULL,
   `userId` int(11) DEFAULT NULL,
   `occuredOn` int(11) DEFAULT NULL,
   `portalId` int(11) DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `userId_idx` (`userId`)
 ) ENGINE=MyISAM DEFAULT CHARSET=latin1
 
MailTrap server credentials:
account: Andonov.goce.93@gmail.com
password: goceandonov
host: smtp.mailtrap.io
username: d468f3d449a1f6
password: 31bee011b6c33b

# SlimRegistration

if [[("$1" = "--All") || ("$1" = "-a")]]
then
    scp -P 23 database/* root@192.168.1.253:/home/pi/Project/Databases/
	scp -P 23 webBaseGUI/pages/* root@192.168.1.253:/var/www/pages/
	scp -P 23 AndroidApp/phpCodes/* root@192.168.1.253:/var/www/androidphp/
elif [[("$1" = "--WebPages") || ("$1" = "-wp")]]
then
	scp -P 23 webBaseGUI/index.php root@192.168.1.253:/var/www/
	scp -P 23 webBaseGUI/pages/* root@192.168.1.253:/var/www/pages/
elif [[("$1" = "--DatabaseFile") || ("$1" = "-df")]]
then
	scp -P 23 database/* root@192.168.1.253:/home/pi/Project/Databases/
elif [[("$1" = "--Androidphp") || ("$1" = "-ap")]]
then
	scp -P 23 AndroidApp/phpCodes/* root@192.168.1.253:/var/www/androidphp/
else
	echo -e "--WebPages\t-wp\tCopy web pages files to Server";
	echo -e "--DatabaseFile\t-df\tCopy database files to Server";
	echo -e "--Androidphp\t-ap\tCopy android php files to Server";
	echo -e "--All\t-a\tCopy all files to Server";
fi

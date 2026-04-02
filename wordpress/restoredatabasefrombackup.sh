#mysqldump -u impaktuser -pJarguf14 intranet > intranetbackup/intranet_`date +%Y%m%d_%H%M%S`.sql
#mysqldump -u impaktuser -pJarguf14 --all-databases > databasebackup/databases_`date +%Y%m%d_%H%M%S`.sql
#mysqldump -u administrator -pLemter20 --all-databases > databasebackup/databases_`date +%Y%m%d_%H%M%S`.sql

# restore

mysql -u adlibrum -pWZ2cZI7pTe8SjhQV adlibrum < adlibrum_2020-05-01.sql

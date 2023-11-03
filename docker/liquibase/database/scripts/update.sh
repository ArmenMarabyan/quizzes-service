#!/bin/bash

docker-compose -f docker-compose-liquibase.yml run liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/master.xml --username=root --password=root update


#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/changelog.xml --username=root --password=root rollbackCount 5
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/changelog.xml --username=root --password=root tag t-1.0
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/changelog.xml --username=root --password=root rollback t-1.0
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/changelog.xml --username=root --password=root update
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --username=root --password=root --changeLogFile=mydatabase_changelog.xml generateChangeLog
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/master.xml --username=root --password=root update --log-level=warning
#    command: liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/master.xml --username=root --password=root rollback create-user
#    liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/master.xml --username=root --password=root update
#!/bin/bash

docker-compose -f docker-compose-liquibase.yml run liquibase --url="jdbc:mariadb://db:3306/test" --changeLogFile=./changelog/master.xml --username=root --password=root rollbackCount $1
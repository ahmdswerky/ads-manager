#!/bin/bash

printf "\nThese are all open ports for Nginx:\n\n";
docker ps --format '{{.Image}} .................................... {{.Ports}}' | grep _nginx | egrep "[0-9]{3,5}"
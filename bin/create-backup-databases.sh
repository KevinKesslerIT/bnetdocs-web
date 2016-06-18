#!/bin/bash

printf "This script will download sensitive material to this machine.\n" 1>&2
read -p "Is this ok [y/N]: " PROMPT
if [ "${PROMPT}" != "Y" ] && [ "${PROMPT}" != "y" ]; then
  printf "Operation aborted.\n" 1>&2
  exit 1
fi

MYSQLHOST="$1"
if [ -z "${MYSQLHOST}" ]; then
  read -p "Enter the MySQL server hostname: " MYSQLHOST
fi
if [ -z "${MYSQLHOST}" ]; then
  printf "MySQL hostname not provided, assuming localhost...\n" 1>&2
  MYSQLHOST="localhost"
fi

MYSQLUSER="$2"
if [ -z "${MYSQLUSER}" ]; then
  read -p "Enter the MySQL user: " MYSQLUSER
fi
if [ -z "${MYSQLUSER}" ]; then
  printf "MySQL user not provided, assuming root...\n" 1>&2
  MYSQLUSER="root"
fi

MYSQLPASS="$3"
if [ -z "${MYSQLPASS}" ]; then
  read -s -p "Enter the MySQL password for ${MYSQLUSER}: " MYSQLPASS
  echo
fi
if [ -z "${MYSQLPASS}" ]; then
  printf "MySQL password not provided, assuming it's not set...\n" 1>&2
fi

set -e

printf "[1/4] Getting path of current project...\n"
SRCDIR="$(git rev-parse --show-toplevel)"

printf "[2/4] Creating new backup directory...\n"
BKUPDIR="${SRCDIR}/tmp/$(date +%Y%m%d-%H%M)"
mkdir -v "${BKUPDIR}"

printf "[3/4] Dumping BNETDocs Redux database...\n"
mysqldump --host="${MYSQLHOST}" --user="${MYSQLUSER}" \
  --password="${MYSQLPASS}" \
  --opt --order-by-primary \
  --complete-insert --single-transaction --triggers --routines \
  --hex-blob --add-drop-database \
  --result-file "${BKUPDIR}/database.redux.sql" \
  --databases bnetdocs_botdev

printf "[4/4] Dumping BNETDocs Phoenix database...\n"
mysqldump --host="${MYSQLHOST}" --user="${MYSQLUSER}" \
  --password="${MYSQLPASS}" \
  --opt --order-by-primary \
  --complete-insert --single-transaction --triggers --routines \
  --hex-blob --add-drop-database \
  --result-file "${BKUPDIR}/database.phoenix.sql" \
  --databases bnetdocs_phoenix

printf "Operation complete!\n"

#!/bin/sh
echo "Waiting for Postgresql..."

until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER" -d "$DB_NAME"; do
  sleep 1
done

echo "Postgresql started \n"

echo "Database migration:"
echo "-----------------------------------"
echo "-----------------------------------"

psqldef -h $DB_HOST -U $DB_USER $DB_NAME --apply --file=schema.sql

echo "-----------------------------------"
echo "-----------------------------------"
echo ""

echo "-----------------------------------"
echo "-----------------------------------"

echo "Creating admin user:"
php scripts/newadmin.php $ADMIN_USER_NAME $ADMIN_USER_EMAIL $ADMIN_USER_PWD

echo ""
echo "-----------------------------------"
echo "-----------------------------------"
echo ""

if [ ! -d "media" ]; then
  echo "Creating media directory..."
  mkdir -p media
  chown 33 -R media
fi

exec "$@"

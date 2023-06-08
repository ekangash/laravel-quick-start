DB_NAME=$1

echo "Поиск дампа archive/psql_dump.txt"
echo "---------------------------------------------"

if [ -n "${DB_NAME}" ]; then
        if [ -f ./archive/psql_dump.txt ]; then
            echo "Разворачивание дампа в базу данных '${DB_NAME}'"
            echo "---------------------------------------------"

            pg_restore -h localhost -p 5432 -U postgres -d "${DB_NAME}" ./archive/psql_dump.txt

            echo "---------------------------------------------"
            echo "Разворачивание дампа базы данных прошло успешно"

            else
               echo "Разворачивание дампа базы данных не удалось"
        fi
    else
       echo "Имя базы данных не передано"
fi

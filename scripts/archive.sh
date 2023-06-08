DB_NAME=$1

echo "Создание директории archive, если она не определена"
echo "---------------------------------------------"
if [ ! -d ./archive ]; then
    mkdir ./archive
fi

if [ -d ./../public/media ]; then
    echo "Копирование медиа файлов приложения"
    echo "---------------------------------------------"
    cp -r ./../public/media ./archive
fi

if [ -n "${DB_NAME}" ]; then
    echo "Экспорт базы данных '${DB_NAME}'"
    echo "---------------------------------------------"
    pg_dump -U root -h localhost -p 5432 -F c -C -d "${DB_NAME}" > ./archive/psql_dump.txt
fi

echo "Архивирование директории archive"
echo "---------------------------------------------"
zip -r ./archive.zip ./archive/*

echo "Проект успешно архивирован"
echo "---------------------------------------------"

echo "Удаление временных файлов"
rm -rf ./archive

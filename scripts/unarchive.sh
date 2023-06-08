echo "Поиск архива archive.zip"
echo "---------------------------------------------"

if [ -f ./archive.zip ]; then
        if [ -d ./archive ]; then
            echo "Очистка существующей директории archive"
            echo "---------------------------------------------"
            rm -rf ./archive/*
        fi

        echo "Начало распаковки архива archive.zip"
        echo "---------------------------------------------"
        unzip archive.zip -d .
        echo "---------------------------------------------"
        echo "Архив archive.zip успешно распакован"
    else
        echo "Архив archive.zip не найден"
fi

# Master Budget

Master Budget - это веб-приложение для управления бюджетом и анализа финансов. Приложение позволяет пользователям вводить и отслеживать бюджетные данные для разных категорий и продуктов на ежемесячной основе.

### Предварительные требования

Для развертывания проекта на локальной машине вам понадобятся следующие предварительные требования:

- PHP версии 7.4 или выше
- Composer (менеджер зависимостей PHP)
- MySQL или другая совместимая база данных
- Веб-сервер (например, Apache или Nginx)

### Установка

1. **Склонируйте репозиторий проекта**:

    ```shell
    git clone https://github.com/master_budget.git
    cd master_budget
    ```

2. **Установите зависимости**:

    ```shell
    composer install
    ```

3. **Создайте базу данных**:

    Создайте базу данных MySQL  `master_budget` и настройте доступ в файле `config/db.php`.

5. **Выполните миграции**:

    Выполните миграции, чтобы создать таблицы в базе данных:

    ```shell
    php yii migrate
    ```

 6. **Добавьте свои данные в masterbudget.json**:

  "type": "service_account",
  "project_id": "masterbudget",
  "private_key_id": "",
  "private_key": "",
  "client_email": "",
  "client_id": "",
  "auth_uri": "",
  "token_uri": "",
  "auth_provider_x509_cert_url": "",
  "client_x509_cert_url": "",
  "universe_domain": "googleapis.com"


6. **Запустите приложение**:
    ```shell
    php yii google-api
    ```


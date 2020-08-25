# Описание задания

Необходимо написать сервис на Lumen 5.*, предоставляющий информацию о валютах в формате JSON.

1. Валюта должна быть представлена следующими полями:
  * id — идентификатор
  * name — название валюты на русском языке
  * english_name — название валюты на английском языке
  * alphabetic_code — буквенный код валюты в ISO 4217
  * digit_code — цифровой код валюты в ISO 4217
  * rate — курс валюты к рублю, значение должно позволять выполнять конвертацию валют

2. Сервис должен реализовывать следующие методы:
  * GET /currencies — должен возвращать список валют со всеми полями
  * GET /currencies/{id} — должен возвращать информацию о валюте для переданного идентификатора

3. Информацию о валютах необходимо хранить в БД.

4. Необходима консольная команда для обновления всех данных, которые необходимо получать через API ЦБР: http://www.cbr.ru/development/SXML/

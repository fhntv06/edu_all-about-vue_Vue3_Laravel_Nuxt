# Vue3

## Project Setup

create file .env.local:
variables for app:

```
VITE_APP_WEATHER_API_URL=your_api_url_to_openweather or https://api.openweathermap.org/data/2.5/weather
VITE_APP_WEATHER_API_KEY=your_api_key_from_openweather
VITE_APP_API_PROTOCOL=your_api_protocol(default value http)
VITE_APP_API_HOST=your_api_host(default value localhost)
VITE_APP_API_PORT=your_api_por(default value 8000)
```

used in app: console.log(process.env.VUE_APP_WEATHER_API_KEY)

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```

### Lint with [ESLint](https://eslint.org/)

```sh
npm run lint
```

### Start server [json-server](https://www.npmjs.com/package/json-server)

```sh
npm run server
```

### Education
[Docs Vue.js](https://vuejs.org/)

**createApp()** - create instance application.

#### Sections in component:
- \<template> => html
- \<script> => js
- \<style> => css

#### Difference between \<script> and \<script setup>
```
<script> -  выполняется только один раз при первом импорте компонента.
<script setup> -  выполняется каждый раз при создании экземпляра компонента.
```  

#### Information about VUEX
- actions - асинхронные операции
- mutations - синхронные операции
- getters - вычисляемые свойства для состояния хранилища
- modules - модули для разделения хранилища на части
- mapState - помощник для отображения состояния хранилища в компоненты
- mapGetters - помощник для отображения геттеров хранилища в компоненты
- mapActions - помощник для отображения действий хранилища в компоненты
- mapMutations - помощник для отображения мутаций хранилища в компоненты
- namespaced - позволяет создавать модули с собственным пространством имен
- createStore - функция для создания нового хранилища Vuex
- useStore - хук для доступа к хранилищу Vuex в компонентах
- commit - метод для вызова мутаций в хранилище
- dispatch - метод для вызова действий в хранилище
- state - объект, содержащий состояние хранилища

В приложении реализован Навигационные guard'ы для защиты маршрутов на основе аутентификации пользователя.

### Errors

#### Error №1 - "Maximum recursive updates exceeded"
Превышено максимальное количество рекурсивных обновлений. Это означает, что у вас есть реактивный эффект, который изменяет свои собственные зависимости и, таким образом, рекурсивно запускает сам себя. Возможные источники включают шаблон компонента, функцию рендеринга, обновленный хук или функцию-наблюдатель.
#### Resolve
Эта ошибка возникает, когда реактивное свойство обновляется таким образом, что возникает бесконечный цикл обновлений. Чтобы устранить эту проблему, убедитесь, что вы не изменяете реактивное свойство напрямую в вычисляемом свойстве или наблюдателе, который зависит от него. Вместо этого используйте методы или другие средства для обновления свойства, не вызывая рекурсивных обновлений.  
В конкретном случае ошибка была при применении **watch** на реактивный масси **posts** с указанием **deep**. Бесконечный цикл образовывался потому что при рендере проиходила фильтрация **posts** с возвратом отфильтрованного массива в родительский компонент, где он снова передавался в дочерний компонент **Filter** и снова фильтровался.


### Created Widgets:
- WeatherWidget - Виджет погоды в разных городах мира
- WorldTimeWidget - Виджет времени в разных городах мира
- UserTimeWidget - Виджет времени пользователя

### Что нужно сделать
1) Переписать авторизацию, регистрацию под Laravel
   2) /login
   3) /registration
   4) /forgot-password
2) Переписать получение данных по API с json-server под Laravel
   3) Отображение списка постов
   4) Создание поста
   5) Удаление поста
   6) Обновление поста


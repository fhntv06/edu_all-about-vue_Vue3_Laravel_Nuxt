#!/bin/bash

# Функция для завершения процессов при выходе
cleanup() {
    echo "Завершаем процессы..."
    kill $FRONTEND_PID $BACKEND_PID $REVERB_PID $QUEUE_PID 2>/dev/null
    exit 0
}

# Устанавливаем обработчик сигналов
trap cleanup SIGINT SIGTERM

# Запуск фронтенда
echo "Запускаем фронтенд в папке ./frontend..."
if [ -d "frontend" ]; then
    cd frontend || exit 1
    echo "▶️ Выполняем: npm run dev"
    npm run dev &
    FRONTEND_PID=$!
    cd ..
else
    echo "Ошибка: папка frontend не найдена"
    exit 1
fi

# Запуск бэкенда
echo "Запускаем бэкенд в папке ./backend..."
if [ -d "backend" ]; then
    cd backend || exit 1

    echo "▶️ Выполняем: php artisan serve"
    php artisan serve &
    BACKEND_PID=$!

    echo "▶️ Выполняем: php artisan reverb:start"
    php artisan reverb:start &
    REVERB_PID=$!

    echo "▶️ Выполняем: php artisan queue:work"
    php artisan queue:work &
    QUEUE_PID=$!

    cd ..
else
    echo "Ошибка: папка backend не найдена"
    kill $FRONTEND_PID 2>/dev/null
    exit 1
fi

echo ""
echo "✅ Все процессы успешно запущены!"
echo "📱 Frontend PID: $FRONTEND_PID (npm run dev)"
echo "⚙️ Backend PID: $BACKEND_PID (php artisan serve)"
echo "🔌 Reverb PID: $REVERB_PID (websocket server)"
echo "📦 Queue Worker PID: $QUEUE_PID (queue:work)"
echo ""
echo "Нажмите Ctrl+C для остановки всех процессов"

# Ожидание завершения процессов
wait
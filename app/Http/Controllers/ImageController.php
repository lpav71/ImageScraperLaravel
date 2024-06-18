<?php

namespace App\Http\Controllers;

use DomDocument;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ImageController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function fetchImages(Request $request)
    {
        // Получаем URL из запроса
        $url = $request->input('url');

        // Создаем клиента Guzzle для отправки HTTP запросов
        $client = new Client();
        $res = $client->request('GET', $url);

        // Получаем содержимое тела ответа
        $body = $res->getBody()->getContents();

        // Используем DomDocument для парсинга HTML содержимого
        $dom = new DomDocument();
        // Загружаем HTML (подавляем ошибки с помощью @)
        @$dom->loadHTML($body);

        // Массив для хранения информации об изображениях
        $images = [];
        // Переменная для хранения общего размера изображений
        $size = 0;

        // Перебираем все теги img в HTML
        foreach ($dom->getElementsByTagName('img') as $img) {
            // Получаем значение атрибута src
            $src = $img->getAttribute('src');

            // Проверяем, является ли src абсолютным URL
            if (!filter_var($src, FILTER_VALIDATE_URL)) {
                // Если нет, формируем абсолютный URL на основе базового URL
                $src = rtrim($url, '/') . '/' . ltrim($src, '/');
            }

            // Отправляем HEAD-запрос для получения заголовка Content-Length
            $img_size = $client->request('HEAD', $src)->getHeaderLine('Content-Length');

            // Переводим размер изображения в мегабайты
            $img_size_mb = (int)$img_size / (1024 * 1024);

            // Суммируем общий размер всех изображений
            $size += $img_size_mb;

            // Сохраняем информацию об изображении в массив
            $images[] = [
                'src' => $src,
                'size_mb' => round($img_size_mb, 2),
            ];
        }

        // Возвращаем представление result с данными об изображениях и их общем размере
        return view('result', [
            'images' => $images,
            'totalSize' => number_format($size, 2),
        ]);
    }
}

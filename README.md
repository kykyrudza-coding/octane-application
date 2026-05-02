# Octane — PHP MVC Application
Легкий PHP MVC Application з власним роутером, ORM, кешем, автентифікацією та системою валідації.

## Зміст

- [Встановлення](#встановлення)
- [Маршрутизація](#маршрутизація)
- [Моделі](#моделі)
- [Колекції](#колекції)
- [Автентифікація](#автентифікація)
- [Кеш](#кеш)
- [Сесії та Flash](#сесії-та-flash)
- [Валідація](#валідація)
- [Представлення](#представлення)
- [Request](#request)
- [Redirect](#redirect)
- [Хелпери](#хелпери)
- [Консоль](#консоль)

---

## Встановлення

```bash
composer install
npm install

cp .example.env .env
# відредагуйте .env під свої параметри
```

Запуск dev-сервера:

```bash
php octane serve          # PHP вбудований сервер
npm run dev               # Parcel (CSS/JS)
```

Збірка для production:

```bash
npm run build
```

---

## Маршрутизація

Маршрути визначаються у `routes/web.php` і повертаються масивом.

### Базові маршрути

```php
use Kernel\Application\Routing\Route;
use App\Http\Controllers\PostController;

return [
    Route::get('/', [PostController::class, 'index']),
    Route::post('/posts', [PostController::class, 'store']),
    Route::put('/posts/{id}', [PostController::class, 'update']),
    Route::patch('/posts/{id}', [PostController::class, 'update']),
    Route::delete('/posts/{id}', [PostController::class, 'destroy']),
];
```

### Closure-маршрути

```php
Route::get('/ping', function (Request $request) {
    return response()->json(['status' => 'ok']);
}),
```

### Параметри маршруту

```php
Route::get('/users/{id}', [UserController::class, 'show']),
Route::get('/posts/{slug}/comments/{id}', [CommentController::class, 'show']),
```

Параметри автоматично додаються до `$request`:

```php
public function show(Request $request): View
{
    $id = $request->input('id');
    // ...
}
```

### Іменовані маршрути

```php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'),
Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show'),
```

Генерація URL:

```php
route('dashboard');                    // /dashboard
route('user.show', ['id' => 42]);      // /users/42
```

### Middleware

```php
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware([AuthMiddleware::class, AdminMiddleware::class]),
```

Middleware отримує `Request` і `Response`. Якщо повернути `false` — виконання маршруту зупиняється:

```php
class AuthMiddleware
{
    public function handle(Request $request, Response $response): bool|null
    {
        if (! auth()->check()) {
            redirect('/login');
        }

        return null;
    }
}
```

### PUT/PATCH/DELETE з HTML-форм

Браузери підтримують лише `GET` і `POST`. Для інших методів використовуйте приховане поле `_method`:

```html
<form method="POST" action="/posts/5">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">Видалити</button>
</form>
```

---

## Моделі

Моделі розміщуються в `app/Model/` і розширюють базовий клас `Model`.

### Визначення моделі

```php
namespace App\Model;

use Kernel\Application\DataBase\Model\Model;

class Post extends Model
{
    protected static string $table = 'posts';

    protected static array $fillable = ['title', 'body', 'user_id'];
}
```

> `$fillable` захищає від масового присвоєння — `create()` і `update()` ігноруватимуть поля, яких тут немає.

### CRUD

```php
// Отримати всі записи
$posts = Post::all(); // Collection

// Знайти за ID
$post = Post::find(1); // ?Post (null якщо не знайдено)

// Перший запис
$post = Post::first(); // ?Post

// Умова вибірки
$posts = Post::where(['user_id' => 3, 'status' => 'active']); // Collection

// Створити
$post = Post::create(['title' => 'Заголовок', 'body' => 'Текст', 'user_id' => 1]); // Post

// Оновити
$post = Post::update(5, ['title' => 'Новий заголовок']); // Post

// Видалити
Post::delete(5); // bool
```

### Доступ до полів

```php
$post = Post::find(1);

echo $post->title;
echo $post->body;

$data = $post->attributes(); // ['id' => 1, 'title' => '...', ...]
```

### Пагінація

```php
$result = Post::paginate(15);

// $result містить:
$result['data'];          // Collection поточної сторінки
$result['current_page'];  // номер поточної сторінки
$result['total_pages'];   // загальна кількість сторінок
$result['total_items'];   // загальна кількість записів
$result['per_page'];      // записів на сторінку
```

У URL сторінка передається через `?page=2`.

---

## Колекції

`Collection` повертається методами `all()`, `where()`, `paginate()['data']`.

### Ітерація

```php
$posts = Post::all();

// foreach (завдяки IteratorAggregate)
foreach ($posts as $post) {
    echo $post->title;
}

// each
$posts->each(function (Post $post) {
    echo $post->title;
});

// count (завдяки Countable)
echo count($posts);
echo $posts->count();
```

### Доступ за індексом

```php
// ArrayAccess
$first = $posts[0];
$second = $posts[1];

echo isset($posts[0]); // true/false

$posts->first(); // перший елемент
$posts->last();  // останній елемент
$posts->get(2);  // елемент за індексом
```

### Функціональні методи

```php
// map — трансформація
$titles = $posts->map(fn(Post $p) => $p->title);

// filter — відбір
$published = $posts->filter(fn(Post $p) => $p->status === 'published');

// pluck — витягнути одне поле
$ids = $posts->pluck('id');       // [1, 2, 3, ...]
$titles = $posts->pluck('title'); // ['...', '...', ...]

// isEmpty
if ($posts->isEmpty()) {
    echo 'Немає записів';
}

// toArray / all
$array = $posts->toArray();
```

---

## Автентифікація

### Вхід

`login()` приймає масив з `email` і `password`. Пароль перевіряється через `password_verify()`, тому в базі він має бути захешований через `password_hash()`.

```php
$ok = auth()->login([
    'email'    => 'user@example.com',
    'password' => 'secret123',
]);

if ($ok) {
    redirect('/dashboard');
} else {
    session()->setFlash('error', 'Невірний email або пароль');
    redirect('/login');
}
```

### Перевірка стану

```php
auth()->check();        // bool — чи залогінений
auth()->user();         // ?array — дані користувача (без пароля) або null
```

```php
if (auth()->check()) {
    $user = auth()->user();
    echo $user['name'];
    echo $user['email'];
}
```

### Вихід

```php
auth()->logout();
redirect('/login');
```

### Middleware для захисту маршрутів

```php
// app/Http/Middlewares/AuthMiddleware.php
class AuthMiddleware
{
    public function handle(Request $request, Response $response): void
    {
        if (! auth()->check()) {
            redirect('/login');
        }
    }
}
```

```php
// routes/web.php
Route::get('/profile', [UserController::class, 'profile'])
    ->middleware(AuthMiddleware::class),
```

### Реєстрація користувача

При створенні — хешуйте пароль самостійно:

```php
User::create([
    'name'     => $request->input('name'),
    'email'    => $request->input('email'),
    'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
]);
```

---

## Кеш

Кеш зберігається у `tmp/cache/` у вигляді JSON-файлів.

### Базові операції

```php
// Записати (TTL у секундах, за замовчуванням 3600)
cache()->set('key', $value);
cache()->set('key', $value, 600); // 10 хвилин

// Отримати (null якщо відсутній або прострочений)
$value = cache()->get('key');

// Видалити
cache()->forget('key');
```

### Remember — отримати або обчислити

```php
$posts = cache()->remember('all_posts', function () {
    return Post::all();
}, 3600);
```

Якщо ключ `all_posts` вже є в кеші — повертає збережене значення. Якщо ні — виконує callback, зберігає результат і повертає його.

### Практичний приклад у контролері

```php
public function index(): View
{
    $posts = cache()->remember('posts_page_'.$page, fn() => Post::paginate(20), 300);

    return view('posts.index', ['result' => $posts]);
}

public function store(Request $request): void
{
    Post::create($request->input());
    cache()->forget('posts_page_1'); // інвалідація після зміни даних
    redirect('/posts');
}
```

---

## Сесії та Flash

### Flash-повідомлення

Flash зберігається лише до наступного запиту:

```php
// Записати
session()->setFlash('success', 'Запис збережено!');
session()->setFlash('error', 'Щось пішло не так.');

// Отримати (після чого видаляється)
$message = session()->getFlash('success');
$all = session()->getFlash(); // всі повідомлення
```

У шаблоні:

```php
<?php $msg = session()->getFlash('success'); ?>
<?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>
```

### Old input (повернення значень форми)

При POST-запиті значення автоматично зберігаються в сесії.

```php
// Отримати попереднє значення поля
$old = $request->old('email');
```

У шаблоні:

```html
<input type="email" name="email"
       value="<?= htmlspecialchars($request->old('email') ?? '') ?>">
```

### CSRF

```php
// Отримати токен
$token = session()->getCsrfToken();
```

```html
<form method="POST" action="/posts">
    <input type="hidden" name="_token" value="<?= session()->getCsrfToken() ?>">
    ...
</form>
```

---

## Валідація

### У контролері

```php
public function store(Request $request): void
{
    $errors = $request->validate([
        'name'     => ['required', 'min:2', 'max:100'],
        'email'    => ['required', 'email'],
        'password' => ['required', 'min:8', 'have_numbers', 'uppercase', 'confirm'],
        'age'      => ['required', 'numeric'],
    ]);

    if (! empty($errors)) {
        session()->setValidationErrors($errors);
        redirect('/register');
    }

    User::create([
        'name'     => $request->input('name'),
        'email'    => $request->input('email'),
        'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
    ]);

    redirect('/dashboard');
}
```

### Доступні правила

| Правило | Опис | Приклад |
|---|---|---|
| `required` | Поле не може бути порожнім | `required` |
| `email` | Валідний email | `email` |
| `min:N` | Мінімальна довжина рядка або значення | `min:3` |
| `max:N` | Максимальна довжина або значення | `max:255` |
| `numeric` | Тільки числа | `numeric` |
| `have_numbers` | Рядок містить хоча б одну цифру | `have_numbers` |
| `uppercase` | Рядок містить хоча б одну велику літеру | `uppercase` |
| `special` | Рядок містить хоча б один спецсимвол | `special` |
| `confirm` | Збігається з полем `{name}_confirmation` | `confirm` |

### Відображення помилок у шаблоні

```php
<?php if (session()->hasValidationError('email')): ?>
    <p class="error"><?= session()->getValidationError('email') ?></p>
<?php endif; ?>

<!-- або через хелпер -->
<?= error('email') ?>
```

Кастомний клас на полі:

```php
<input type="email" name="email"
       class="<?= hasError('email', 'input', 'input input--error') ?>">
```

---

## Представлення

Шаблони розміщуються в `resources/views/`. Це звичайні PHP-файли.

### Рендеринг з даними

```php
// У контролері
return view('posts.index', [
    'posts' => Post::all(),
    'title' => 'Всі пости',
]);
```

```php
// resources/views/posts/index.php
<h1><?= htmlspecialchars($title) ?></h1>

<?php foreach ($posts as $post): ?>
    <article>
        <h2><?= htmlspecialchars($post->title) ?></h2>
        <p><?= htmlspecialchars($post->body) ?></p>
    </article>
<?php endforeach; ?>
```

### Layout

```php
// resources/views/layout/top.php
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Octane' ?></title>
</head>
<body>
```

```php
// resources/views/posts/index.php
<?php include views_path('layout/top.php') ?>

<main>
    ...контент...
</main>

<?php include views_path('layout/bottom.php') ?>
```

---

## Request

```php
// Отримати значення (POST, GET або old)
$request->input('name');
$request->input('name', 'default');
$request->input(); // весь POST + GET

// Тільки GET-параметр
$request->get('page', 1);

// Перевірити наявність
$request->has('email');

// Файл
$request->file('avatar');         // дані файлу з $_FILES
$request->hasFile('avatar');      // bool

// Cookie
$request->cookie('theme');

// Метадані
$request->method();       // GET, POST, PUT, ...
$request->uri();          // /posts/5?page=2
$request->ip();           // 127.0.0.1
$request->userAgent();    // Mozilla/5.0 ...
$request->back();         // HTTP_REFERER або '/'
```

---

## Redirect

```php
redirect('/dashboard');
redirect(route('user.show', ['id' => $user->id]));
redirect($request->back());
```

---

## Хелпери

| Функція | Повертає | Опис |
|---|---|---|
| `view($name, $data)` | `View` | Рендер шаблону |
| `route($name, $params)` | `string` | URL за іменем маршруту |
| `redirect($url)` | `void` | HTTP-редірект |
| `request()` | `Request` | Поточний запит |
| `response()` | `Response` | Поточна відповідь |
| `session()` | `Session` | Інстанс сесії |
| `auth()` | `Auth` | Інстанс автентифікації |
| `cache()` | `Cache` | Інстанс кешу |
| `abort($code, $msg)` | `void` | HTTP-помилка (404, 500, ...) |
| `env($key, $default)` | `mixed` | Змінна середовища |
| `config($key, $default)` | `mixed` | Значення конфігурації |
| `storage_path($path)` | `string` | Шлях до `storage/` |
| `views_path($path)` | `string` | Шлях до `resources/views/` |
| `app_path($path)` | `string` | Шлях до кореня проєкту |
| `error($field)` | `void` | Виводить помилку валідації |
| `hasError($field, $ok, $fail)` | `string` | Клас залежно від помилки |

---

## Консоль

```bash
# Запустити PHP вбудований сервер
php octane serve

# Створити SQLite базу даних
php octane db:create

# Прив'язати storage до public/
php octane storage:link
```

---

## Структура проєкту

```
├── app/
│   ├── Http/
│   │   ├── Controllers/     # контролери
│   │   └── Middlewares/     # middleware
│   └── Model/               # моделі
├── config/
│   ├── app.php              # основний конфіг (БД, ключ, URL)
│   └── config.php           # entrypoint конфігурації
├── core/                    # ядро застосунку (не редагувати)
├── database/                # SQLite-файл (у .gitignore)
├── public/                  # web-root (index.php, скомпільовані assets)
├── resources/
│   ├── views/               # PHP-шаблони
│   ├── css/app.css
│   └── js/app.js
├── routes/web.php            # маршрути
├── storage/images/           # завантажені файли
├── tmp/
│   ├── cache/               # файли кешу
│   ├── sessions/            # файли сесій
│   └── logs/
└── .env                     # змінні середовища (не в git)
```

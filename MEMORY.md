# MEMORY.md — Memoria del proyecto Laravel

> Qué se ha visto en clase, qué se decidió y en qué estado está el proyecto.
> **Cómo usarlo:** léelo antes de trabajar. Al terminar una tarea que cambie el esquema, tome una decisión o detecte un error, actualiza la sección correspondiente y añade una línea a la bitácora.
> **Nunca** guardes aquí credenciales, contraseñas ni datos personales.

---

## 1. Avance del curso

Fuentes: *Unidad Temática I — Introducción a Laravel* y *Unidad Temática II — Base de Datos*. Lo visto llega **hasta factories y seeders**.

**Unidad I — Introducción a Laravel**
- [x] Esquema de versiones (principal / menor / parche) y política de soporte (correcciones de errores 18 meses, de seguridad 2 años; versiones LTS)
- [x] Guía de actualización (los apuntes cubren Laravel 11 → 12; **este proyecto corre sobre Laravel 13**: `laravel/framework:^13.17`, PHP `^8.3`, Pest `^4.7`). El procedimiento es el mismo: respaldo, actualizar dependencias, ejecutar pruebas
- [x] Qué es Laravel y por qué usarlo (MVC, Eloquent, Blade, migraciones, autenticación integrada)
- [x] Entorno en Windows: XAMPP, virtual host, variables de entorno (PHP en el PATH), Composer, VS Code, Git, GitHub con VS Code, Node.js, AdminLTE
- [x] Crear un proyecto (`composer create-project` o `laravel new`)
- [x] Configuración: `.env`, `config/app.php`, publicar idioma, limpieza de cachés
- [x] Arquitectura MVC y estructura de directorios
- [x] Autenticación con `laravel/ui`, recordar contraseña, verificación en dos pasos de Google (contraseña de aplicación para SMTP)

**Unidad II — Base de datos**
- [x] Conceptos: tabla, registro, atributo, clave primaria y foránea
- [x] Modelo Entidad-Relación y relaciones (uno a uno, uno a muchos, muchos a muchos, a través de otra tabla)
- [x] Análisis de requerimientos (funcionales, no funcionales, de dominio) y **supuestos** de base de datos
- [x] Configuración de la BD (`.env` y `config/database.php`)
- [x] Migraciones: tipos de datos, partes de una migración, modificar tablas, comandos de ejecución y reversión, 10 ejercicios en clase
- [x] Modelos Eloquent (`$table`, `$primaryKey`, `$fillable`, relaciones)
- [x] **Factories** (`$this->faker` vs `fake()`)
- [x] **Seeders** (`DatabaseSeeder`, `call()`, `migrate:fresh --seed`)

**Aún no cubierto en los apuntes** (no asumir dominio del estudiante): CRUD completo con rutas y controladores, validación (Form Requests), consultas Eloquent avanzadas (`with`, `where`, agregaciones), Blade a fondo, API, pruebas con Pest.

---

## 2. Decisiones y configuración del proyecto

**Creación del proyecto (respuestas del asistente de `laravel new`)**
- Starter kit: `none` (la autenticación se agrega después con `laravel/ui`)
- Pruebas: **Pest**
- Repositorio Git: sí
- Base de datos: **MySQL**
- Migraciones por defecto: sí
- `npm install` y `npm run build`: sí

**`.env` de desarrollo (solo valores no sensibles)**
```
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_ES
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=CancionesArtistas # nombre real de la base (verificado en el error de conexión); los apuntes usan `laravel12`
DB_USERNAME=root             # usuario por defecto de Laragon/XAMPP
DB_PASSWORD=                 # vacía en local
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl          # 465 con ssl, o 587 con tls
```
`MAIL_USERNAME`, `MAIL_PASSWORD` y `MAIL_FROM_ADDRESS` se configuran localmente y **no** se documentan aquí. `MAIL_PASSWORD` es una contraseña de aplicación de Google, no la contraseña personal.

Como sesiones, caché y colas usan `database`, las migraciones por defecto crean tablas para ellas además de `users`.

**`config/app.php`**
- `'timezone' => 'America/Bogota'` (antes `'UTC'`)
- `locale` en español vía `APP_LOCALE=es`; carpeta `lang/es` y `lang/es.json` (tras `php artisan lang:publish`)

**Versión y entorno real del proyecto (verificado en el repo)**
- Laravel **13.29.0** (`composer.json`: `laravel/framework:^13.17`, PHP `^8.3`); los apuntes ven Laravel 12 → mismos conceptos, versión distinta.
- Ruta real: `C:\laragon\www\CancionesArtistas` con **Laragon** (PHP 8.3.33). El material de clase usa XAMPP y `C:\xampp\htdocs\<proyecto>`.
- En la terminal del agente `php`/`composer` **no están en el PATH**: `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64` y `C:\laragon\bin\composer\composer.bat`.
- **No existe AdminLTE ni `public/backend`** en este repo: la plantilla del material de clase no se copió. La autenticación es `laravel/ui` + Bootstrap (`resources/views/auth/`, `layouts/app.blade.php`).
- **MySQL de Laragon está apagado por defecto** y hay que arrancarlo antes de `migrate:status` o `db:seed` (el 2026-10-01 estaba apagado y bloqueaba todo con `SQLSTATE[HY000]`):
  ```powershell
  Start-Process -FilePath "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini" -WindowStyle Hidden
  Start-Sleep -Seconds 6
  ```
  `datadir = C:/laragon/data/mysql-8.4`. El `.pid` de esa carpeta quedó apuntando a otro proceso (obsoleto): no sirve para saber si MySQL corre; usar `Get-Process mysqld` o `Test-NetConnection 127.0.0.1 -Port 3306`.
- Virtual host opcional (si se usa Apache de Laragon): entrada en `C:\Windows\System32\drivers\etc\hosts` (`127.0.0.1 prueba.local`) y bloque `<VirtualHost *:80>` en `C:\laragon\apache\conf\extra\httpd-vhosts.conf` con `DocumentRoot` apuntando a `.../public`.

---

## 3. Dominio: canciones y artistas (Songs / Artists / SongsArtists)

> **Nombres del proyecto:** modelos `Song`, `Artist`, `SongArtist`; tablas `songs`, `artists` y `songs_artists` (intermedia).
> Todo lo demás (`facturas`, `clientes`, `productos`…) es solo el caso de estudio de clase → ver **Anexo** al final. Esas tablas **no existen en este repo**.

### 3.1 Esquema real (verificado en `database/migrations/`)

| Tabla | Columnas |
|---|---|
| `artists` | `id`, `name` (index), `genre` null, `bio` text null, `country` null, `image_path` null, `status` boolean default `true`, `registered_by` FK `users` null, timestamps |
| `songs` | `id`, `title` (index), `album` null, `duration_in_seconds` unsigned int null, `release_date` date null, `genre` null, `status` boolean default `true`, `registered_by` FK `users` null, timestamps |
| `songs_artists` | `id`, `song_id` → `songs.id`, `artist_id` → `artists.id`, `producer` null, timestamps. ~~`unique(artist_id, song_id)`~~ → **quitado el 2026-10-02** por la migración `2026_10_02_220639_drop_unique_from_songs_artists_table` |
| `users` | + columna `photo` string null (migración `add_photo_to_users_table` con `Schema::table()`) |

- **Orden:** `artists` y `songs` → `songs_artists` (pivot). `up()`/`down()` simétricos en todas.
- Diferencia con las convenciones del curso: aquí se usan `status`/`registered_by` (snake_case, boolean), no `estado`/`registradopor`. Manda la migración (art. 5.8).

### 3.2 Relaciones Eloquent (proyecto)

| Modelo | Relación | Método |
|---|---|---|
| `Artist` | uno a muchos con `SongArtist` | `songArtists()` → `hasMany(SongArtist, 'artist_id')` |
| `Song` | uno a muchos con `SongArtist` | `songArtists()` → `hasMany(SongArtist, 'song_id')` |
| `SongArtist` | muchos a uno con `Artist` | `artist()` → `belongsTo` |
| `SongArtist` | muchos a uno con `Song` | `song()` → `belongsTo` |

- **No hay `belongsToMany`** directo entre `Artist` y `Song`: el many-to-many se recorre por el pivot `SongArtist` (`$incrementing = true` porque `songs_artists` tiene su propio `id`).
- Equivalencias vistas en clase: uno a uno `hasOne`/`belongsTo`; uno a muchos `hasMany`/`belongsTo`; muchos a muchos `belongsToMany`; a través de otra tabla `hasManyThrough`.

### 3.3 Estado y pendientes del proyecto

**Resuelto el 2026-10-01**

- `app/Models/Song.php`: `casts(): array` estaba **sin cuerpo** → error de sintaxis real. `php -l` y `pint --test` lo marcaban, pero `php artisan test` **no** (ninguna prueba carga el modelo). Ahora devuelve `['release_date' => 'date:Y-m-d']`.
- Factories llenadas con **lo mínimo**: solo las columnas `NOT NULL` sin valor por defecto.

  | Factory | Lo que aporta | Por qué no más |
  |---|---|---|
  | `ArtistFactory` | `name` (`unique()->name()`) | `genre`, `bio`, `country`, `image_path` son null; `status` tiene default |
  | `SongFactory` | `title` (`unique()->words(3, true)`) | `album`, `duration_in_seconds`, `release_date`, `genre` son null; `status` tiene default |
  | `SongArtistFactory` | **solo** el fragmento del profesor: `'song_id' => Song::inRandomOrder()->first()->id` + `'artist_id' => Artist::inRandomOrder()->first()->id` | Forma literal que pidió el profesor (2026-10-02). `producer` es null → se omite. Requiere que `songs` y `artists` ya tengan filas |

- `DatabaseSeeder` crea 10 usuarios + **20 `Song` + 20 `Artist` + 200 `SongArtist`** con la línea que pidió el profesor: **`SongArtist::factory(200)->create();`**. Verificado el 2026-10-02 en transacción con *rollback*: exit 0 → **31 / 40 / 40 / 400**, sin error, datos intactos al volver (21 / 20 / 20 / 200).

**Pendiente**

- Modelos con el atributo `#[Fillable([...])]` (Laravel 13) en lugar de la propiedad `$fillable` que pide el art. 2.6 → falta unificar.
- `SongArtist` incluye `status` en su `#[Fillable]`, pero esa columna **no existe** en `songs_artists`.
- `php vendor\bin\pint --test` falla por estilo en **12** archivos (los 3 modelos, `HomeController`, las 4 migraciones, `routes/web.php`, `lang/es/*`). Ninguna factory ni el seeder.

---

## 4. Patrones de factories y seeders

> Los ejemplos usan los nombres del **caso de estudio de clase** (sistema de ventas → ver **Anexo**). En este repo los modelos son `Artist`, `Song`, `SongArtist`.

**Factories (`database/factories`)**
- `php artisan make:factory NombreFactory --model=Modelo`, método `definition(): array`.
- Datos de ejemplo vistos: `faker->word()`, `randomFloat(2, min, max)`, `sentence()`, `numberBetween()`, `imageUrl()`, `name()`, `address()`, `phoneNumber()`, `unique()->safeEmail()`, `randomElement([...])`, `date()`.
- `estado` se genera como `'1'`; `registradopor` con `name()`.
- FK con factory relacionada (crea el registro si hace falta): `'cliente_id' => Cliente::factory()`.
- **Reutilizar registros que ya existen** (fragmento del profesor): `'product_id' => Product::inRandomOrder()->first()->id` y `'supplier_id' => Supplier::inRandomOrder()->first()->id`. *(En este repo se usa con `'song_id' => Song::inRandomOrder()->first()->id` / `'artist_id' => Artist::inRandomOrder()->first()->id`, desde el 2026-10-02.)*
- `$this->faker` es lo recomendado dentro de factories; `fake()` es un helper global (útil fuera de clases).

**Seeders (`database/seeders`)**
- `DatabaseSeeder` es el principal; llama a otros con `$this->call([ClienteSeeder::class, ...])`.
- Ejemplo de clase: 3 métodos de pago, 20 productos, 10 clientes; por cliente de 1 a 3 facturas; por factura detalles, total calculado, 1 o 2 pagos y saldo pendiente.
- Atajo: `Producto::factory()->count(20)->create();`
- **Inserción masiva** (fragmento del profesor): tomar los ids con `pluck('id')`, montar `$data` dentro de un `for` y escribirlo todo de una vez con `DB::table('nombre_de_tu_tabla')->insert($data)` → **1 sola consulta**. Si la tabla tiene `timestamps`, agregar `created_at` y `updated_at` a mano: el query builder **no** los rellena (el profesor lo deja en un comentario "descomenta si tu tabla tiene timestamps"). *Este repo **no** lo usa desde el 2026-10-02: manda `Model::factory()->count(N)->create()`; sigue siendo patrón de clase.*

**En este repo (dominio Songs / Artists) — verificado 2026-10-01/02**
- Todo está en el `run()` de `DatabaseSeeder`; no usa `call()`: 10 usuarios, 20 canciones, 20 artistas y 200 asociaciones.
- Las factories nuevas usan `$this->faker` (art. 6.1). `UserFactory` (plantilla de Laravel) usa `fake()` con `unique()->safeEmail()`, por eso el seeder admite repetirse sin chocar con el `unique` de `email`.
- **`SongArtistFactory` contiene únicamente el fragmento del profesor** (forma fijada el 2026-10-02): `'song_id' => Song::inRandomOrder()->first()->id` y `'artist_id' => Artist::inRandomOrder()->first()->id`. Sin lógica adicional, sin `?->`, sin lista de pares.
- **Ese fragmento elige con repetición** → medido, 200 intentos dan **152–162 pares distintos** sobre los 400 posibles. Con la tabla vacía y el `UNIQUE` activo revienta **entre el registro 5 y el 49** (promedio 23 de 200), con `UniqueConstraintViolationException … key 'songs_artists_artist_id_song_id_unique'`.
- **Por eso el `UNIQUE(artist_id, song_id)` se quitó** el 2026-10-02 con la migración **nueva** `2026_10_02_220639_drop_unique_from_songs_artists_table` (`dropUnique`, reversible en `down()`). El estudiante confirmó que **el UNIQUE no lo pidió el profesor**; la migración original no se tocó (art. 5.1).
- **Consecuencia medida:** los pares **sí se repiten** — 400 filas → **286 pares distintos, 114 repetidas**. Es lo que pidió el profesor, no un defecto que haya que corregir.
- **Precondición:** `songs` y `artists` deben tener filas **antes** de la factory; si no, `first()` devuelve `null` y `->id` truena. El seeder las crea antes.
- **El seeder quedó en 4 líneas** (la forma del profesor): `User::factory(10)`, `Song::factory()->count(20)`, `Artist::factory()->count(20)` y `SongArtist::factory(200)->create()`. **Sin bucles, sin `DB::table()->insert()`, sin `createMany()`.**
- **Verificado el 2026-10-02** en transacción con *rollback*: la línea suelta creó **200 filas sin error**; el seeder completo dio exit 0 → **31 / 40 / 40 / 400** y los datos quedaron intactos (21 / 20 / 20 / 200). `php artisan test` → 2 passing; `php -l` y `pint --test` limpios en los archivos tocados.
- **Verificación sin ensuciar la BD:** correr `db:seed` dentro de una transacción con `DB::rollBack()` al final → subió a 40/40/400 con **0 pares duplicados y 0 FK inválidas**, y el *rollback* devolvió 20/20/200. Sirve para probar un seeder completo sin duplicar datos (los `DELETE` masivos no hacen falta).

---

## 5. Comandos aprendidos

| Para qué | Comando |
|---|---|
| Crear proyecto | `composer create-project laravel/laravel nombre` · o `laravel new nombre` (tras `composer global require laravel/installer`) |
| Servidor | `php artisan serve` · `npm run dev` · `composer run dev` |
| Migración / modelo / factory / seeder | `make:migration`, `make:model`, `make:factory --model=`, `make:seeder` |
| Ejecutar migraciones | `migrate` · `migrate:status` · `migrate --pretend` · `migrate --isolated` · `migrate --force` |
| Migración específica | `migrate --path=database/migrations/<archivo>.php` |
| Revertir | `migrate:rollback` (`--step=N`, `--batch=N`) · `migrate:reset` · `migrate:refresh` · `migrate:fresh` |
| Sembrar | `db:seed` · `db:seed --class=<Seeder>` · `migrate:fresh --seed` |
| Idioma | `lang:publish` |
| Caché | `cache:clear` · `config:clear` · `config:cache` · `route:clear` · `view:clear` · `event:clear` · `clear-compiled` · `optimize:clear` |
| Almacenamiento público | `storage:link` |
| Clave de aplicación | `key:generate` |
| Autenticación | `composer require laravel/ui` · `php artisan ui bootstrap --auth` · `npm install` · `npm run dev` |
| Pruebas | `php artisan test` |
| Actualizar Laravel | `composer require laravel/framework:^13.0` · `composer update` (proyecto actual: `^13.17`) |
| Verificar sintaxis | `php -l <archivo>` · `php vendor\bin\pint --test` |

Diferencias clave: `rollback` deshace el último lote; `reset` deshace todas las migraciones; `refresh` las deshace y las vuelve a ejecutar (conserva la tabla `migrations`); `fresh` **borra todas las tablas** y migra de nuevo (solo desarrollo).

---

## 6. Inconsistencias conocidas del material de clase

Al implementar, **corregir** esto y no copiarlo tal cual. (Se refieren al caso de estudio de ventas del **Anexo**.)

1. **Comillas faltantes en migraciones.** Aparecen `$table->string(imagen)`, `string(estado)`, `string(registradopor)`, `string(tipopago)` y `decimal(saldopendiente, 10, 2)`. Los nombres de columna van entre comillas: `string('imagen')`. En `onDelete` la flecha debe ser `->onDelete(...)` (en el texto aparece `>onDelete`, probablemente por la copia del documento).
2. **`precio_unitario` sin columna.** El modelo `Detallefactura` lo incluye en `$fillable` y la factory calcula con él, pero la migración de `detallefacturas` no tiene esa columna. Decidir: agregar la columna con una migración nueva o quitarla del `$fillable`.
3. **Nombres de columna distintos entre migración, factory y seeder.** La migración usa `fechapago` y `saldopendiente`; `PagoFactory` y el seeder de ejemplo usan `fecha_pago` y `saldo_pendiente`. Manda la migración.
4. **Campos obligatorios omitidos en el seeder de ejemplo.** `Detallefactura::create(...)` y `Pago::create(...)` no envían `registradopor` (ni `estado` en `pagos`), que son `NOT NULL` sin valor por defecto: fallaría.
5. **Aleatoriedad frágil en el seeder.** `rand(50, $saldo)` falla si `$saldo` es menor que 50, y `rand(1, 5)` dentro de la condición del `for` se reevalúa en cada vuelta, por lo que el número de detalles no es el esperado. El comentario dice 10 métodos de pago pero el código crea 3.
6. **Mayúsculas inconsistentes en nombres de clase.** Mezcla de `Detallefactura`/`DetalleFactura` y `MetodoPago`/`Metodopago` entre modelos, `use` y factories. Funciona en Windows (sistema de archivos insensible a mayúsculas) y se rompe en Linux/macOS. Elegir una grafía y usarla en todo. Además, Laravel busca por convención `Database\Factories\<Modelo>Factory`, así que el nombre del factory debe coincidir con el del modelo.
7. **Relación mal descrita.** El texto dice "un pago puede tener varios métodos de pago". Lo correcto es: un **método de pago tiene muchos pagos** y cada **pago pertenece a un método**.
8. **`migrate --isolated`.** En los ejercicios se pregunta por una "transacción aislada". Según la documentación de Laravel, la bandera usa un **bloqueo atómico mediante el driver de caché** para evitar que dos servidores ejecuten migraciones a la vez durante un despliegue.
9. **Credenciales reales en los apuntes.** El ejemplo de `.env` de la Unidad I muestra un correo y una contraseña de aplicación con aspecto de reales. No reutilizarlos, y si fueran reales, **revocar esa contraseña de aplicación** y generar otra.

---

## 7. Bitácora

- 2026-10-01 — Se crea `AGENTS.md`, `MEMORY.md` y `CONSTITUTION.md` a partir de las Unidades I y II (hasta factories y seeders).
- 2026-10-01 — Se corrige la versión en los tres archivos: el proyecto corre sobre **Laravel 13.29.0** (`^13.17`), no 12 (los apuntes ven 11 → 12). Se documenta el esquema real de este repo (`songs`, `artists`, `songs_artists`) y se actualiza el entorno real (Laragon en `C:\laragon\www\CancionesArtistas`, no XAMPP).
- 2026-10-01 — El caso de estudio de ventas (`facturas`, `clientes`, `productos`…) se mueve al **Anexo**, para que el cuerpo de `MEMORY.md` describa solo el dominio del proyecto: **Songs / Artists / SongsArtists**.
- 2026-10-01 — Se corrige `app/Models/Song.php` (`casts()` sin cuerpo → error de sintaxis que las pruebas no detectaban), se llenan las 3 factories con lo mínimo necesario y `DatabaseSeeder` pasa a crear **20 canciones, 20 artistas y 200 asociaciones** canción-artista (pares únicos tomados de las 400 combinaciones posibles). Verificado: `php artisan db:seed` → 20/20/200 con 200 pares distintos, `php artisan test` → 2 passing, `php -l` limpio en los 5 archivos tocados. MySQL de Laragon estaba apagado: se arrancó y quedó documentado cómo.
- 2026-10-01 — `SongArtistFactory` pasa de `Song::factory()` (creaba registros nuevos) al **fragmento del profesor**: `Song::inRandomOrder()->first()?->id`, que **reutiliza registros ya existentes**. Se añade `?->` al fragmento original para no chocar con *"property on null"* si la tabla está vacía. Medido: la aleatoriedad libre daría **47 colisiones** de 200 (por `UNIQUE(artist_id, song_id)`), así que el seeder sigue barajando él mismo. Probado el seeder completo **en transacción con rollback**: 40/40/400, **0 duplicados**, y los datos quedaron intactos en 20/20/200. `php artisan test` → 2 passing.
- 2026-10-02 — El `DatabaseSeeder` se reescribe con **la forma del profesor** (`pluck` → `for` → `DB::table()->insert($data)`), sin `foreach`, sin `createMany()`. Dos adaptaciones obligatorias, ambas descubiertas **probando** y no suponiendo: (1) `->random()` revienta por `UNIQUE` → se usa `crossJoin` + `shuffle`; (2) `Song::pluck('id')` a secas traía las canciones de sembradas anteriores y sus pares chocaban con los existentes → se ata a `Song::factory()->count(20)->create()->pluck('id')`. Verificado en transacción con *rollback*: exit 0, 40/40/400, **0 duplicados y 0 FK inválidas**, datos intactos. `pint --test` pasa en seeder y factories (global: 12 archivos, los mismos preexistentes) y `php artisan test` → 2 passing. *(Este apunte quedó **reemplazado** por el siguiente: ese seeder ya no existe.)*
- 2026-10-02 (2) — El estudiante pide usar **la línea del profesor tal cual**: `SongArtist::factory(200)->create();`, porque su profesor le dijo que lo dejara simple por ahora. Se comprueba **antes de escribir nada** (solo lectura) que esa línea no puede funcionar sola: genera 200 instancias con solo **156 pares distintos → 44 repetidos**, y **69** ya estaban en la tabla → `UniqueConstraintViolationException` por `UNIQUE(artist_id, song_id)`. Decisión del estudiante: **la complejidad se muda a `SongArtistFactory` y el seeder queda en la línea del profesor** (ni la BD ni el `UNIQUE` se tocan). La factory arma una `protected static ?array $paresDisponibles` con todos los pares `canción × artista` que aún **no** están en la tabla (`crossJoin` + `reject` + `shuffle`) y entrega el siguiente con `array_shift()`; si se acaban lanza `RuntimeException`. **Se retiró el fragmento `Song::inRandomOrder()->first()?->id`** — era justo lo que producía las repeticiones. Verificado: la línea suelta con la BD en 20/20/200 deja **justo 200 pares libres** → **200 creados, 0 duplicados, 0 FK inválidas**, con las 20 canciones y los 20 artistas repartidos por igual; y el seeder completo en transacción con *rollback* → 40/40/400, 0 duplicados, datos intactos en 20/20/200. `pint --test` pasa en seeder y factories; `php artisan test` → 2 passing. *(Commit `a432e0b`.)* *(Este apunte quedó **reemplazado**: el pool ya no existe.)*
- 2026-10-02 (3) — El estudiante vuelve a traer el fragmento de clase, ahora con los nombres del Anexo: `'song_id' => Product::inRandomOrder()->first()->id,` + `'artist_id' => Supplier::inRandomOrder()->first()->id,`, pidiendo correr los 200 con `SongArtist::factory(200)->create();`. **Se avisa antes de escribir código** (art. 1): el fragmento y el `UNIQUE(artist_id, song_id)` son incompatibles, porque `inRandomOrder()->first()` muestrea **con repetición** y sobre los 400 pares posibles 200 intentos dan **~157 distintos → ~43 repetidos** (medido en este repo: 156 / 44). También se aclara que un `do … while (exists())` dentro de la factory **no** lo salva: `create()` construye las 200 instancias **antes** de insertar, así que no vería los pares del mismo lote — por eso la solución es la lista precalculada. **Decisión del estudiante: mantener el pool.** No cambia el código (ya estaba en esa forma); `Product`/`Supplier` no existen aquí, los modelos son `Song` y `Artist`. Los tres caminos posibles (pool / quitar el `UNIQUE` con una migración nueva / fragmento tal cual y que truene) se le presentaron y eligió el primero. *(Este apunte quedó **reemplazado** por el siguiente: el estudiante volvió sobre la decisión.)*
- 2026-10-02 (4) — El estudiante vuelve con **la instrucción del profesor**: `SongArtistFactory` debe contener **solo** las dos líneas (`'song_id' => Song::inRandomOrder()->first()->id` + `'artist_id' => Artist::inRandomOrder()->first()->id`) y correr con `SongArtist::factory(200)->create();`. Se corre la prueba decisiva **antes de tocar nada**: con la tabla **vacía** y el `UNIQUE` activo, el fragmento revienta **entre el registro 5 y el 49** (10 corridas, promedio 23 de 200) con `UniqueConstraintViolationException`; con la BD real da **152–162 pares distintos de 200**. Se explica por qué al profesor sí le funciona: en el caso de clase `detallefacturas` **no tiene `UNIQUE`** (una factura sí puede repetir un producto), mientras que `songs_artists` sí lo tenía. **El estudiante confirma que el `UNIQUE` no lo pidió el profesor** → se elimina. Acciones: (1) migración **nueva** `2026_10_02_220639_drop_unique_from_songs_artists_table` con `dropUnique(['artist_id','song_id'])` y `down()` que lo restaura — la migración original **no se toca** (art. 5.1); (2) `SongArtistFactory` queda **solo** con las dos líneas del fragmento; (3) `DatabaseSeeder` **no cambia** (ya era la línea literal). Verificado: `php artisan migrate` → DONE y la tabla queda con **solo** `primary(id)`; la línea suelta crea **200 filas sin error** (400 filas → 286 pares distintos, **114 repetidas**, comportamiento esperado ahora); seeder completo en transacción → exit 0, **31/40/40/400**, rollback → 21/20/20/200 intactos; `php artisan test` → 2 passing; `php -l` y `pint --test` limpios. **Deja sin efecto lo que dicen los arts. 6.3 y 6.4 de `CONSTITUTION.md`** sobre unicidad de pares → **enmendados el mismo día** junto con 6.2, 6.6, 2.6 y 5.7 (ver "Enmienda parte 3" en la cabecera).
- 2026-10-02 (5) — El estudiante plantea que el atributo `#[Fillable([...])]` de los modelos podría deberse a que **este proyecto corre en Laravel 13 y el ejemplo del profesor está en Laravel 12**. **Verificado contra el repo oficial de Laravel:** el archivo `src/Illuminate/Database/Eloquent/Attributes/Fillable.php` **devuelve 404 en la rama `12.x` y sí existe en `13.x`** → **la hipótesis es correcta, `#[Fillable]` es nuevo de Laravel 13.** Además se comprueba que el framework lo lee de verdad: `GuardsAttributes::initializeGuardsAttributes()` hace `mergeFillable(resolveClassAttribute(Fillable::class, 'columns') ?? [])`, o sea **fusiona** las columnas del atributo con la propiedad `$fillable` (no la reemplaza). Comprobado en ejecución: `(new Song)->getFillable()` devuelve las 7 columnas declaradas con `#[Fillable]`. **Conclusión:** los modelos **no están mal escritos**; la discrepancia con el art. 2.6 (que pide la propiedad `$fillable`) es una **diferencia de versión**, no un error. Los `Attributes` disponibles en 13 son 22 (`Fillable`, `Guarded`, `Unguarded`, `Hidden`, `Table`, `Connection`, `Appends`, `UseFactory`, `ObservedBy`, …). **Pendiente de enmienda:** arts. 2.6 y 5.7 de `CONSTITUTION.md`.

---

## Anexo — Caso de estudio de clase: sistema de ventas

> **Material de clase, no existe en este repo.** Sirve para practicar migraciones, relaciones, factories y seeders con nombres distintos a los del proyecto (`songs`, `artists`, `songs_artists`).

### A.1 Supuesto documentado en clase

- **Hallazgo:** el cliente pidió "registrar ventas", pero se observó que se manejan **ventas a crédito** y la factura tenía un campo de saldo pendiente.
- **Supuesto:** el sistema debe contemplar ventas a crédito.
- **Implicación:** campos `tipopago` y `saldopendiente` en `facturas`, y tablas nuevas `metodopagos` y `pagos` (abonos a una factura).

### A.2 Esquema (según los apuntes)

| Tabla | Columnas |
|---|---|
| `productos` | `id`, `nombre` string, `precio_venta` decimal(8,2), `precio_compra` decimal(8,2), `descripcion` text null, `stock` integer, `imagen` string, `estado` string, `registradopor` string, timestamps |
| `clientes` | `id`, `nombre`, `direccion`, `telefono`, `email` string **unique**, `estado`, `registradopor`, timestamps |
| `facturas` | `id`, `fecha` date, `total` decimal(10,2), `cliente_id` → `clientes.id`, `tipopago` string (contado / crédito), `saldopendiente` decimal(10,2) null, `estado`, `registradopor`, timestamps |
| `detallefacturas` | `id`, `factura_id` → `facturas.id` (**cascade**), `producto_id` → `productos.id`, `cantidad` integer, `subtotal` decimal(10,2), `registradopor`, timestamps. *No tiene `estado`.* |
| `metodopagos` | `id`, `nombre` (efectivo, tarjeta, transferencia…), `descripcion` text null, `estado`, `registradopor`, timestamps |
| `pagos` | `id`, `factura_id` → `facturas.id` (**cascade**), `fechapago` date, `monto` decimal(10,2), `metodopago_id` → `metodopagos.id` (**restrict**), `estado`, `registradopor`, timestamps |

**Orden de creación (por dependencias):** `clientes`, `productos`, `metodopagos` → `facturas` → `detallefacturas`, `pagos`.

### A.3 Relaciones Eloquent

| Modelo | Relación | Método |
|---|---|---|
| `Producto` | uno a muchos con `Detallefactura` | `detallefacturas()` → `hasMany(..., 'producto_id')` |
| `Cliente` | uno a muchos con `Factura` | `facturas()` → `hasMany(..., 'cliente_id')` |
| `Factura` | muchos a uno con `Cliente` | `cliente()` → `belongsTo` |
| `Factura` | uno a muchos con `Detallefactura` | `detallefacturas()` → `hasMany(..., 'factura_id')` |
| `Detallefactura` | muchos a uno con `Factura` y `Producto` | `factura()`, `producto()` → `belongsTo` |
| `MetodoPago` | uno a muchos con `Pago` | `pagos()` → `hasMany(..., 'metodopago_id')` |
| `Pago` | muchos a uno con `Factura` y `MetodoPago` | `factura()`, `metodoPago()` → `belongsTo` |

Equivalencias generales vistas en clase: uno a uno `hasOne`/`belongsTo`; uno a muchos `hasMany`/`belongsTo`; muchos a muchos `belongsToMany`; a través de otra tabla `hasManyThrough`.

**Ejemplo de modificación de tabla existente:** migración `add_photo_to_users_table` (sí existe en este repo) que usa `Schema::table('users', ...)` para agregar `photo` (string, nullable) en `up()` y `dropColumn('photo')` en `down()`.

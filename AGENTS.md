# AGENTS.md — Guía operativa para agentes (opencode)

Proyecto académico de Laravel. Responde **siempre en español**.

## Lectura obligatoria antes de actuar

1. `CONSTITUTION.md` — reglas no negociables. **Prevalecen sobre todo lo demás**; solo el estudiante las edita (tú puedes proponer cambios).
2. `MEMORY.md` — qué se vio en clase, decisiones, esquema e inconsistencias conocidas del material.

Si una petición choca con la constitución, avisa y pide confirmación antes de continuar.

## Estado real del proyecto (verificado en el código, no en los apuntes)

| Hecho | Valor verificado |
|---|---|
| Framework | Laravel **13.29.0** (`composer.json`: `laravel/framework:^13.17`), PHP `^8.3` |
| Ubicación | `C:\laragon\www\CancionesArtistas` (Laragon; los apuntes hablan de XAMPP/`C:\xampp\htdocs`) |
| Dominio | **Canciones y artistas**: modelos `Song`, `Artist`, `SongArtist`; tablas `songs`, `artists`, `songs_artists` (pivot con `producer`; **sin** restricción de unicidad desde el 2026-10-02). El caso de estudio de ventas está solo en el **Anexo de `MEMORY.md`**: **no existe en este repo** |
| Modelos | `Artist`, `Song`, `SongArtist` (`extends Pivot`, con `$incrementing = true`) |
| Auth | `laravel/ui` con Bootstrap: `/`, `Auth::routes()`, `/home` → `HomeController`; vistas en `resources/views/auth/` y `layouts/app.blade.php` |
| Pruebas | Pest sobre **sqlite `:memory:`** (`phpunit.xml`): no tocan MySQL. `php artisan test` → **2 passing** |
| Datos de ejemplo | `php artisan db:seed` crea **10 usuarios + 20 `Song` + 20 `Artist` + 200 `SongArtist`** con **`SongArtist::factory(200)->create();`**, que corre porque la tabla **ya no tiene `UNIQUE`**. Los pares **sí se repiten** (~114 de 400 filas): es el comportamiento pedido. Verificado 2026-10-02: 21/20/20/200 |
| No existe | `routes/api.php`, `public/backend` (AdminLTE), `.github/` ni CI, `pint.json` |

## Entorno (Windows + Laragon)

`php` y `composer` **no están en el PATH** de la shell del agente. Antes de cualquier comando:

```powershell
$env:Path += ";C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64"
php artisan migrate:status
C:\laragon\bin\composer\composer.bat <comando>
```

(Si esa carpeta de PHP no existe, búscala con `Get-ChildItem C:\laragon\bin\php`.)

- **MySQL de Laragon debe estar iniciado** para `migrate:status`, `db:seed` o cualquier cosa que toque la BD. Si ves `SQLSTATE[HY000] ... denegó expresamente dicha conexión`, no es error del código: falta MySQL. La base real se llama **`CancionesArtistas`**.
- Para **arrancar MySQL** si está apagado (probado el 2026-10-01):

  ```powershell
  Start-Process -FilePath "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\laragon\bin\mysql\mysql-8.4.3-winx64\my.ini" -WindowStyle Hidden
  Start-Sleep -Seconds 6
  ```

  Comprobación: `Get-Process mysqld` o `Test-NetConnection 127.0.0.1 -Port 3306`. El `.pid` de `C:\laragon\data\mysql-8.4\` puede quedar obsoleto tras un apagado abrupto: **no fiarse de él**.
- **Comandos que sí funcionan sin MySQL:** `php artisan test` (2 pruebas en verde), `php vendor\bin\pest tests\Feature\ExampleTest.php` (un archivo), `php artisan --version`, `php -l <archivo>`.
- `composer test` (config:clear + `artisan test`) y `composer run dev` (→ `php artisan dev`) son válidos si `php` está en el PATH.
- Frontend: `npm run dev` / `npm run build` (npm 11). Vite solo compila `resources/sass/app.scss` y `resources/js/app.js`.
- Tras cambios de configuración, rutas, vistas o `.env`: `php artisan optimize:clear` antes de concluir que "algo no funciona".

## Advertencias de este repositorio (revisar antes de tocar Git)

- **`.env` está versionado y NO está en `.gitignore`** (viola art. 2.3): avisa antes de cualquier `git add`. `vendor/` también está versionado (~10.300 archivos). Nunca imprimas valores de `.env`.
- Rama por defecto: **`main`** (los apuntes dicen `master`). Remoto `origin` → GitHub. **Confirma antes de `git push`.**
- **`app/Models/Song.php` estaba roto** (corregido el 2026-10-01): `casts(): array` **sin cuerpo** → `php -l` y `pint --test` fallaban, pero `php artisan test` **no** lo detecta porque ninguna prueba carga el modelo. Lección: nunca des por sano un archivo solo porque las pruebas pasen; verifica con `php -l`. Ahora `casts()` devuelve `['release_date' => 'date:Y-m-d']`.
- `php vendor\bin\pint --test` sigue fallando por estilo en **12 archivos** (los 3 modelos, `HomeController`, las 4 migraciones, `routes/web.php` y `lang/es/*`). **Ninguna factory ni el seeder** está en esa lista.
- Cambios sin commitear: `AGENTS.md`, `app/Models/Song.php` (cuerpo de `casts()`), las 3 factories, `database/seeders/DatabaseSeeder.php`, la migración `2026_09_17_120700_create_songs_artists_table` (agrega `->constrained(...)`), y `CONSTITUTION.md`/`MEMORY.md` sin rastrear. Mira `git diff` antes de sobrescribir nada.
- Si una migración **ya se ejecutó** en alguna base, no la edites (art. 5.1): crea una nueva con `Schema::table()`.

## Discrepancias ya detectadas (no las repliques en silencio)

- Migraciones usan `status` (boolean) y `registered_by`; la constitución/apuntes piden `estado` (string `'1'`) y `registradopor`. **Manda la migración** (art. 5.8), pero comenta la diferencia.
- `SongArtist` incluye `status` en su `#[Fillable]`, columna que **no existe** en `songs_artists`.
- Los modelos usan el atributo **`#[Fillable([...])]`**. **Verificado el 2026-10-02: es nuevo de Laravel 13** — el archivo `src/Illuminate/Database/Eloquent/Attributes/Fillable.php` **da 404 en la rama `12.x`** de `laravel/framework` y sí existe en `13.x`. El framework lo **fusiona** con la propiedad (`GuardsAttributes::mergeFillable()`), y en ejecución `(new Song)->getFillable()` devuelve las columnas declaradas. El art. 2.6 pide `$fillable` porque los apuntes van en **Laravel 12**, donde ese atributo no existe. **No lo "corrijas"**: es diferencia de versión, no un error. (Pendiente de enmienda: arts. 2.6 y 5.7.)
- Las factories de `Artist` (`name`) y `Song` (`title`) están **llenadas con lo mínimo**: solo las columnas `NOT NULL` sin default. No les añadas campos extra "para que se vea mejor".
- **`SongArtistFactory` usa el fragmento del profesor, literal** (forma fijada el 2026-10-02): `'song_id' => Song::inRandomOrder()->first()->id` + `'artist_id' => Artist::inRandomOrder()->first()->id`, y corre con **`SongArtist::factory(200)->create();`**. Ese fragmento elige **con repetición** → medido, 200 intentos dan **152–162 pares distintos** sobre los 400 posibles.
- **Por eso el `UNIQUE(artist_id, song_id)` se quitó el 2026-10-02** con la migración **nueva** `2026_10_02_220639_drop_unique_from_songs_artists_table` (`dropUnique`, reversible en `down()`). El estudiante confirmó que **ese UNIQUE no lo pidió el profesor**; la migración original **no se tocó** (art. 5.1). Consecuencia: los registros **sí traen pares repetidos** — medido, 400 filas → **286 pares distintos (114 repetidas)**. **No lo "arregles"**: ni vuelvas a poner el índice, ni metas una lista de pares libres en la factory, ni añadas `?->` al fragmento. Es exactamente lo que pidió el profesor.
- **Precondición:** `songs` y `artists` deben tener filas **antes** de `SongArtist::factory(200)->create()`; si están vacías, `first()` devuelve `null` y `->id` truena. En `DatabaseSeeder` se crean antes, y la factory **no** debe agregarle lógica para cubrir ese caso.
- `DatabaseSeeder` quedó mínimo, en la forma que pidió el profesor: `User::factory(10)`, `Song::factory()->count(20)`, `Artist::factory()->count(20)` y **`SongArtist::factory(200)->create()`**. **Sin `foreach`, sin `DB::table()->insert()`, sin `createMany()`.**

## Qué no asumir

En clase se va **hasta factories y seeders** (`MEMORY.md` §1). CRUD completo con rutas/controladores, Form Requests, consultas Eloquent avanzadas, Blade a fondo, API y pruebas en profundidad **aún no se han visto**: si hace falta, introdúcelos explicando y pidiendo confirmación (art. 4.2). Sin proponerlo primero: no agregues paquetes ni arquitecturas nuevas.

## Comandos que exigen confirmación previa del estudiante (Art. 3)

`migrate:fresh` (± `--seed`), `migrate:reset`, `migrate:refresh`, `migrate:rollback`, `migrate --force`, `db:wipe`, borrar o reescribir migraciones ya ejecutadas, `DROP`/`TRUNCATE`/`DELETE` sin `WHERE`, `git reset --hard`, `git push --force`, borrar ramas. Nunca contra una base de datos de producción.

## Flujo recomendado (art. 9)

1. Lee `MEMORY.md` y la migración real de las tablas implicadas.
2. Si el requisito es vago: declara el supuesto y regístralo en `MEMORY.md`.
3. Cambios pequeños y verificables (una migración / un modelo / un factory por paso).
4. Verifica con el comando real y di qué corriste y qué dio (`migrate:status`, `php artisan test`, `php -l`, `pint --test`).
5. Actualiza `MEMORY.md` (sección correspondiente + bitácora). Sin credenciales ni datos personales.

## Git

Commits pequeños con mensaje en español en `main`. Confirma con el estudiante antes de `git push`; avisa si un `git add` arrastraría `.env` o `vendor/`.

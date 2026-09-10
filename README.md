# Introductie

Dit document beschrijft de stageopdracht die in de komende zes maanden
wordt uitgevoerd. Sneller afronden mag altijd. Het betreft de
stageopdracht voor Petra Nedeljkovic.

# Opdracht

Bouw met behulp van Symfony een systeem dat wedstrijdgegevens uit een
MySQL-database haalt. Het systeem toont voor het actuele sportweekend een
overzicht met het aantal wedstrijden per sport en het aantal uitslagen dat
nog ontbreekt.

De applicatie gebruikt Symfony als framework en is opgebouwd uit entities,
controllers, een service, repositories en Twig-views. De gebruiker opent de
homepage en krijgt daar het overzicht van de sporten en wedstrijden te zien.

Het overzicht bevat de volgende informatie:

| Sportsoort | Aantal wedstrijden | Aantal ontbrekende uitslagen |
|---|---:|---:|
| Volleybal |  |  |
| Handbal |  |  |
| Korfbal |  |  |
| Basketbal |  |  |
| Dammen |  |  |
| Voetbal |  |  |
| IJshockey |  |  |

De gegevens worden rechtstreeks uit de bestaande tabellen `wedstrijd`,
`sporten` en `competities` gelezen. Wedstrijden worden aan een sport
gekoppeld via de code in het competitienummer.

# Werking van het overzicht

De homepage berekent automatisch het meest recente vrijdag-tot-en-met-zondag
weekend. Op vrijdag verschuift het overzicht naar het nieuwe weekend. Daardoor
kunnen er aan het begin van vrijdag nog veel ontbrekende uitslagen zijn,
omdat een deel van de wedstrijden nog moet worden gespeeld.

Het aantal ontbrekende uitslagen wordt bepaald wanneer een van de twee scores
van een wedstrijd nog niet is ingevuld. De homepage toont per sport:

- het totale aantal wedstrijden;
- het aantal wedstrijden zonder volledige uitslag;
- de gekozen vrijdag-tot-en-met-zondag periode.

De kaart voor ontbrekende uitslagen is klikbaar. De gebruiker gaat daarmee
naar `/ontbrekende-uitslagen`, waar de afzonderlijke wedstrijden met een
ontbrekende score worden getoond. Daar kan een eigen begin- en einddatum
worden ingevoerd.

# Technische opbouw

## Entities

- `src/Entity/Sport.php` koppelt aan de tabel `sporten`.
- `src/Entity/Competitie.php` koppelt aan de tabel `competities`.
- `src/Entity/Wedstrijd.php` koppelt aan de tabel `wedstrijd`.

## Controllers

- `src/Controller/HomeController.php` berekent de actuele weekendperiode en
	toont het hoofd overzicht op `/`.
- `src/Controller/WedstrijdController.php` toont de ontbrekende uitslagen op
	`/ontbrekende-uitslagen`.
- `src/Controller/wedstrijdApiController.php` levert wedstrijdgegevens als
	JSON voor API-gebruik.

## Service en repository

`src/Services/WedstrijdService.php` vormt de service-laag tussen controllers
en databasequeries. `src/Repository/WedstrijdRepository.php` bevat de SQL-
queries voor wedstrijden, weekendtotalen en ontbrekende uitslagen.

## Views

- `templates/base.html.twig` is de gezamenlijke basislayout.
- `templates/home/index.html.twig` toont het weekendoverzicht.
- `templates/wedstrijd/ontbrekende.html.twig` toont de ontbrekende uitslagen
	met datumfilters.

# Werkwijze tijdens de stage

Na een wijziging wordt de applicatie stap voor stap gecontroleerd:

1. Wijzig de relevante entity, controller, service, repository of Twig-view.
2. Controleer Twig, YAML, PHP-syntax, de service container en de routes met
	 `.\validate.ps1`.
3. Wis de Symfony-cache met `php bin/console cache:clear` wanneer oude
	 templates of configuratie zichtbaar blijven.
4. Gebruik `.\fix-cache.ps1` wanneer cache- of OneDrive-permissieproblemen
	 optreden.
5. Test de homepage en `/ontbrekende-uitslagen` in de browser.

De standaardvalidatie kan worden uitgevoerd met:

```powershell
.\validate.ps1
```

Of met automatisch cache legen:

```powershell
.\validate.ps1 -ClearCache
```

De entity-mapping kan afzonderlijk worden gecontroleerd met:

```powershell
php bin/console doctrine:schema:validate --skip-sync
```

`--skip-sync` controleert alleen de Doctrine-mapping. De database bevat een
bestaande legacy-structuur met meer tabellen en kolomdefinities dan deze
applicatie beheert. Daarom moet `doctrine:schema:update --force` niet zonder
controle op deze database worden uitgevoerd.

# Starten van het project

Installeer eerst de PHP-dependencies:

```powershell
composer install
```

Start daarna de Symfony-server:

```powershell
symfony server:start
```

Open vervolgens:

```text
http://127.0.0.1:8000
```

De applicatie gebruikt volgens `DATABASE_URL` de bestaande MySQL-database met
de tabellen `wedstrijd`, `sporten` en `competities`. De huidige
`compose.yaml` en `compose.override.yaml` bevatten daarnaast de standaard
Symfony PostgreSQL-service; die is niet dezelfde database als de bestaande
MySQL-bron voor deze stageopdracht.

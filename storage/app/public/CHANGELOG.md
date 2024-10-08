# ChangeLog

### 20241001

- Add RaceRoom tracking and statistics

### 20240918

- Bring back race split info and drivers. It was blown when new list was added
- Add new ACC lobby detector and discord notifier

### 20240916

- Implemented Iban's frontend entry resolver and table for races

### 20240912

- Add persistance of dashboard and drivers list modes to localStorage. Improve visuals on those selectors
- Update Pitskill License systems
- Update driver refreshing algorithm
- Add objective times to hotlap dashboards
- Unify all medals logic and show proper medal colors into HotLap dashboard

### 20240901

- Add LFM License plates
- Update enroll colors
- Add hotlap archiving

### 20240827

- Update enrollment links for LFM to include the suffixes

### 20240825

- Avoid requiring a resolved car in enrollments
- Adjust ELO & SR earners rounding

### 20240818

- Finally add LFM support

### 20240810

- Complete rework of application into a BE/FE architecture
- Porting of JSONs & parsers to Laravel
- Complete rework of datamodel
- Componentization of frontend and complete migration to Vue3 and CompositionAPI
- Migrate front to routed version

## V.0

### 20240805

- Remove X axis labels for sparlines
- Avoid 0 values in stats
- Fix TCX<->GTC PCup category

### 20240731

- Unify hotlap and fetch.
- Add logging

### 20240730

- Add safe logged execution of fetchers and parsers
- Add categories and car models to hotlaps parser and report
- Add frontend <> backend version control and removed auto reload

### 20240729

- **Add HotLap section**
- Reorder Tops sections
- Create a HotLapResults parser
- Detect PitRep promotions
- Add icons an proper responsive tabs

### 202407271

- Add Discord channel webhook registration notification system and data model
- Remove link previews from discord messages
- Adjust toolbar responsive behavior
- Add drivers info to subscription message

### 20240727

- **Split promotions and changes in Tops**
- **Add last update of backend**
- Add changelog link and changelog
- Remove paddings to content
- Added dates to stats
- Add proper scrolls to dialogs
- Fix some styling elevations

## V 0.2 Improvement Phase 1

- Add hovers for all available fields.
- Fix stats
- Avoid duplicates in Ids
- Add user manager (array of ids in json file), password protected
- Create zoom icons instead of hovers
- Add manifest images the logos from Audet to icon-192x192.png and icon-512x512.png
- Add manifest
- AutoRefresh
- Remove last update column
- Create user statistics (locally track numerica)
- Fix license and remove unused columns
- Remove most backend html and value transformation favoring fe interpretation

## V 0.1 Vuetified

- Afegides taules dinàmiques per ordenar columnes.
- Afegits 'tabs' per poder accedir a tota la informació de forma més senzilla.
- Afegit cercador de cada concepte
- Canviat els ordres per preferència d'accéss
- Els registres ara intensifiquen el color en funció dels inscrits de l'equip
- S'informa del servidor de la cursa quan et situes sobre l'event
- Es pot accedir a l'enllaç directe per inscriure's a l'event
- Eliminades columnes superflues
- Afegida la imatge del circuit quan et situes al damunt.
- Disposem d'un subdomini directe per accedir al contingut https://pitskill.latrup.net
- Es pot accedir al perfil del pilot de PitSkill des de la llista de pilots
- L'informe d'inscripcions indica el temps que queda fins a la cursa

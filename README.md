## Module OGSpy SuperApix

Ce module permet de collecter automatiquement les données du jeu OGame via son API XML publique et de les importer dans OGSpy.

### Pré Requis ###

* Nécessite OGSpy >= 3.3.9 — [Dépôt OGSpy](https://github.com/ogsteam/ogspy)
* Modules OGspy requis : Xtense

### Fonctionnalités ###

* Collecte des données joueurs depuis l'API XML d'OGame (`players.xml`)
* Collecte des données alliances (`alliances.xml`)
* Collecte des données de l'univers (`universe.xml`)
* Collecte des données serveur (`serverData.xml`)
* Classements joueurs : points, économie, technologie, militaire (construit, détruit, perdu, honneur)
* Classements alliances : points, économie, technologie, militaire (construit, détruit, perdu, honneur)
* Intégration avec les callbacks Xtense (espionnages, rapports de combat, expéditions, bâtiments, etc.)
* Barre de progression lors de la mise à jour
* Mode développeur pour la journalisation des actions

### Installation ###

Le module s'installe via le gestionnaire de modules d'OGSpy. Le fichier `install.php` crée automatiquement les tables nécessaires en base de données.

### Configuration ###

La configuration s'effectue depuis la page d'administration du module :

* **Numéro d'univers** : numéro du serveur OGame (ex : `67` pour `s67-fr.ogame.gameforge.com`)
* **Pays** : code pays du serveur OGame (ex : `fr`, `it`, `en`)
* **Nombre de requêtes max** : limite du nombre d'appels API par session (recommandé : 500)
* **Temporisation API** : délai entre deux appels API, de 1 à 3 secondes
* **Mode développeur** : active la journalisation détaillée des actions du module
* **Options CallBacks Xtense** : active ou désactive les remontées automatiques depuis l'extension navigateur Xtense (espionnages, messages, expéditions, bâtiments, recherches, flottes, défenses)

### Pour nous contacter ###

* [Forum OGSteam](https://forum.ogsteam.eu) : Vous y trouverez notre équipe de support ainsi que l'invitation vers notre salon Discord
* Discord : https://discord.gg/Azcb67b

### Licence ###

GPL-2.0-only — voir [GNU General Public License](http://opensource.org/licenses/gpl-license.php)

### Historique des Versions ###

Version 0.4.8
- Mise à jour de compatibilité OGSpy 3.3.9

Version 0.4.0
- Ajout de la barre de progression lors de la mise à jour
- Intégration des callbacks Xtense
- Ajout des classements alliances et joueurs (économie, technologie, militaire)

Version 0.3.0
- Ajout de la collecte des données serveur (`serverData.xml`)
- Ajout du mode développeur

Version 0.2.0
- Ajout de la collecte des classements joueurs et alliances
- Ajout de la temporisation configurable entre les appels API

Version 0.1.0
- Première version
- Collecte des données joueurs, alliances et univers via l'API XML d'OGame

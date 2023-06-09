--- Nettoyer le cache applicatif/db etc ---
php bin/console cache:clear ( --env=test  )




--- Update les annotations, groups par exemple ---
composer req doctrine/annotations




--- Créer la base de donnée  ---
php bin/console doctrine:database:create / d:c:c ( --env=test )




--- Créer nouveau fichier migrations ---
php bin/console make:migration



--- Lancer les migrations ---
php bin/console doctrine:migrations:migrate / d:m:m




--- Lancer les fixtures ---
php bin/console hautelook:fixtures:load ( --env=test  )




--- Lancer les tests ---
php vendor/bin/phpunit ( tests/Functional/TodoTest.php )

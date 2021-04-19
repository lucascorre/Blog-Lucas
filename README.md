# Blog-Corre-Lucas

TP devback - Blog-Lucas

DEMARRER LE PROJET 

Cloner le repository avec la commande :

- git clone https://github.com/lucascorre/Blog-Lucas.git

Puis ouvrir un terminal à la racine du projet est tapez la commande :

- composer install 

Suivie de

- composer update. 

Ensuite lancer les migrations pour la BDD avec la commande :

- php bin/console doctrine:migrations:migrate

Une fois la BDD créé, il faut load les fixtures avec :

- php bin/console doctrine:fixtures:load

Et pour finir éxécuter le serveur symfony :

- symfony serve

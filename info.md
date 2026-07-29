# Installation — premier compte administrateur

L'inscription publique est désactivée pour empêcher un visiteur de créer un compte et d'accéder aux données de la mairie.

Après l'installation de l'application et l'exécution des migrations, créez le premier compte avec la commande suivante :

```powershell
php artisan mairie:install-superadmin
```

La commande demande le nom, l'adresse e-mail et le mot de passe du premier administrateur. Le compte créé reçoit le rôle `superadmin` et son adresse e-mail est déjà vérifiée.

La commande fonctionne uniquement s'il n'existe encore aucun utilisateur. Ensuite, connectez-vous avec ce compte pour créer et gérer les autres administrateurs depuis l'application.

## Commandes d'installation

```powershell
php artisan migrate --force
php artisan mairie:install-superadmin
```

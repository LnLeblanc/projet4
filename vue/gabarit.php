<!doctype html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="Ce blog présente le dernier livre de Jean Forteroche : 'Aller simple pour l'Alaska' de façon interactive : l'auteur de l'oeuvre prend en compte les commentaires des lecteurs pour écrire la suite de l'histoire.">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title><?= $titre ?></title>
        <link rel="stylesheet" href="contenu/projet4.css?<?= time(); ?>">
        <link rel="icon" href="contenu/img/favicon.jpg">
    </head>
    
    <body>
        <div id="conteneur">
            <header>
                <h1>Billet simple pour l'Alaska</h1>
                <p>Jean Forteroche</p>
            </header>
            <section>
                <?= $contenu ?>
            </section>
            <footer>
                <p>Site école réalisé par Hélène Leblanc pour OpenClassrooms, projet 4 du parcours Développeur Web Junior<br>
                hébergeur : 1&amp;1. Adresse postale : 1&amp;1 Internet SARL, 7 place de la Gare, BP 70109, 57201 Sarreguemines Cedex<br>
                Images libres de droit récupérées sur pixabay.com, wikipedia.org et wikimedia.org</p>
            </footer>
        </div>
    </body>

</html>
<?php $this->titre = 'Administration'; ?>
<!-- navigation dans l'administration -->
<nav>
    <ul>
        <li><a href="index.php?action=admin" title="Accueil de l'administration">Chapitres en ligne</a></li>
        <li><a href="index.php?action=admin#gestionComm" title="Commentaires signalés">Gestion des commentaires</a></li>
        <li><a href="index.php?action=admin&rubrique=deconnexion" title="Déconnexion de l'administration">Déconnexion</a></li>
    </ul>
</nav>
<section id="adminChap">
    <div class="administration">
        <!-- zone de création d'un nouveau chapitre avec tinyMce -->
        <article class="articleChapitre">
            <h2>Création d'un nouveau billet : </h2>
            <form method="post" action="index.php?action=admin&rubrique=postChap">
                <label for="titre">Titre : </label><br>
                <input type="text" name="titre" id="titre"><br>
                <label for="extrait">Extrait : </label><br>
                <textarea name="extrait" id="extrait" rows="8" ></textarea><br>
                <label for="contenu">Contenu : </label><br>
                <textarea name="contenu" id="contenu" rows="40"></textarea><br>
                <input type="hidden" name="id" value="<?= $nouvelId; ?>">
                <input type="submit" value="enregistrer" class="bouton">
            </form>
        </article>
    </div>
</section>

<script type="text/javascript" src="contenu/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinyMCE.init({
    mode : "textareas",
    theme : "modern"
    });
</script>
<?php $this->titre = 'Administration'; ?>

<!-- navigation dans l'administration -->
<nav>
    <ul>
        <li><a href="index.php?action=admin" title="Accueil de l'administration">Chapitres en ligne</a></li>
        <li><a href="index.php?action=admin&rubrique=nouveauBillet" title="Création d'un chapitre">Nouveau chapitre</a></li>
        <li><a href="index.php?action=admin#gestionComm" title="Commentaires signalés">Gestion des commentaires</a></li>
        <li><a href="index.php?action=admin&rubrique=deconnexion" title="Déconnexion de l'administration">Déconnexion</a></li>
    </ul>
</nav>

<section class="adminUpdate">
    <div class="administration">
        <!-- Zone de mise à jour du billet sélectionné, avec TyniMce -->
        <article class="articleChapitre">
            <h2>Mise à jour d'un chapitre : </h2>
            <form method="post" action="index.php?action=admin&rubrique=updateBillet&id=<?= $billet['id']; ?>">
                <label for="titre">Titre : </label><br>
                <input type="text" name="titre" id="titre" value="<?= $billet['titre']; ?>"><br>
                <label for="extrait">Extrait : </label><br>
                <textarea name="extrait" id="extrait" rows="8" ><?= $billet['extrait']; ?></textarea><br>
                <label for="contenu">Contenu : </label><br>
                <textarea name="contenu" id="contenuAdmin" rows="40"><?= $billet['contenu']; ?></textarea><br>
                <input type="submit" value="mettre à jour" class="bouton">
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
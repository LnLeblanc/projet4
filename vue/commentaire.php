<?php
// Si le numéro de billet passé par l'URL n'est pas bon
if(empty($billet))
{
    echo 'Erreur numéro billet';
}
// sinon on affiche le contenu :
else
{
?>

<!-- Menu de navigation -->
<nav>
    <ul class="navigation">
        <li><a href="index.php" title="Page de présentation">Accueil</a></li>
        <?php if($_GET['id'] > 1)
        {?>
        <li><a href="index.php?action=billet&id=<?= $_GET['id']-1; ?>&page=1">Chapitre précédent</a></li>
        <?php
        }?>
        <?php if($_GET['id'] < $nbBillets)
        {?>
        <li><a href="index.php?action=billet&id=<?= $_GET['id']+1; ?>&page=1">Chapitre suivant</a></li>
        <?php
        }?>
    </ul>
</nav>

<section id="<?= $section ?>">
    <div class="sectionCom">
    <h2><?= $billet['titre']; ?></h2>
    <p><?= $billet['contenu']; ?></p>
    <p>
        <em>Publié le <?= $billet['dateCrea']; ?></em>
    </p>
    
    <?php if(isset($_SESSION['identifiant'])) {
        echo '<a href="index.php?action=admin&rubrique=update&id='. $billet['id'].'" title="Administration: mise à jour">Mettre à jour le chapitre</a> | <a href="index.php?action=admin&rubrique=deleteBillet&id='. $billet['id'].'" title="Administration: supprimer le chapitre">Supprimer</a>';
    } ?>

    <!-- Affichage des commentaires qui correspondent au bon billet -->
    <h2 id="postCom">Commentaires</h2>
    <?php 
    if(!empty($commentaires))
    {
        foreach($commentaires as $commentaire)
        {
            if ($commentaire->id_billet() == $_GET['id'] && $commentaire->valide() == 'TRUE')
            {
            ?>
                <h3><?= $commentaire->auteur(); ?></h3>
                <p>
                    <em>Posté le <?= $commentaire->date_commentaire(); ?></em>
                </p>
                <p>" <?= $commentaire->commentaire(); ?> "</p>
                <form method="post" action="index.php?action=signalerCom&idCom=<?= $commentaire->id(); ?>&idBillet=<?= $commentaire->id_billet(); ?>">
                    <label for="signaler"><em>Ce commentaire vous paraît déplacé ?</em></label>
                <input type="submit" name="signaler" value="Signaler" id="bouton">
                </form>
            <?php
            }
        }
    }
    else
    {
        echo 'Aucun commentaire';
    }
    // pagination s'il y a plus d'une page de comms
    if ($nbPages > 1)
    {
        echo '<br>Page : ';
        for($i=1; $i<$nbPages+1; $i++)
        {
        ?>
            <a href="index.php?action=billet&id=<?= $_GET['id']; ?>&page=<?= $i; ?>#postComm" title="Autre page de commentaires"><?= $i; ?></a> | 
        <?php
        }
    }
    ?>    
    <!-- Pour poster un nouveau commentaire -->
    <h2 id="ajoutCom">Ajouter un commentaire : </h2>
    <form method="post" action="index.php?action=commenter">
        <p id="formulaireCom">
            <label for="auteur">Votre pseudo : </label><br>
            <input type="text" name="auteur" id="auteur"><br>
            <label for="comm">Votre commentaire : </label><br>
            <textarea name="comm" id="comm" rows="7" cols="50"></textarea><br>
            <input type="hidden" name="idBillet" value="<?= $_GET['id']; ?>">
            <input type="submit" value="Valider" class="bouton">
        </p>
         <p class="info">
            <?php 
            if(isset($_SESSION['info']) || $_SESSION['info'] != '')
            {
                echo $_SESSION['info']; 
                $_SESSION['info'] = '';
            }
            ?>
        </p>
    </form>
    </div>
</section>
<?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
     <!-- On limite le fichier à 100Ko -->
     <!--<input type="hidden" name="MAX_FILE_SIZE" value="100000">-->
     Fichier : <input type="file" name="avatar"><br>
     <input type="submit" name="ok" value="Envoyer le fichier">
</form>


<?php
if(isset($_POST['ok'])){
$dossier = 'photos/';
$fichier = basename($_FILES['avatar']['name']);
$tailleMaxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('png', 'gif', 'jpg', 'jpeg');
$extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
}
if($taille>$tailleMaxi)
{     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier))
      //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               echo 'Upload effectué avec succès !';
     
     else //Sinon (la fonction renvoie FALSE).
             echo 'Echec de l\'upload !';
     

}
else
    echo $erreur;
}
?>

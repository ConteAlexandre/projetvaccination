<?php $title='Mes Vaccins'; ?>


<?php include('inc/pdo.php') ?>
<?php include('inc/fonction.php') ?>
<?php include('inc/header.php');

if (islogged()) {

  $iduser = $_SESSION['v3_user']['v3_id'];
  $errors = array();


  $sql = "SELECT * FROM v3_vac_vaccins ORDER BY statuts ASC";
      $query = $pdo->prepare($sql);
      $query->execute();
  $vaccins = $query->fetchAll();

  $sql = "SELECT id_vaccins FROM v3_users_vaccins WHERE id_user = :iduser";
      $query = $pdo->prepare($sql);
      $query->bindValue(':iduser',$iduser);
      $query->execute();
  $vaccinsUser = $query->fetchall();
  $vaccinUser = array();
  foreach ($vaccinsUser as $k) {
    $vaccinUser[] = $k['id_vaccins'];
  }

  // debug($vaccinUser);

  // ajout d'un vaccin a faire sur la table user_vaccin

  $sql = "SELECT * FROM v3_vac_vaccins AS vvv
              LEFT JOIN v3_users_vaccins AS vuv
              ON vvv.id = vuv.id_vaccins
              WHERE id_user = :iduser
              ORDER BY date, statuts ASC";
          $query = $pdo->prepare($sql);
          $query->bindValue(':iduser',$iduser);
          $query->execute();
  $verifVacId = $query->fetchAll();


  // debug($vaccins);



  if (!empty($_POST['submitted'])) {


    $dateVAC = trim(strip_tags($_POST['date']));
    $vaccinVAC = trim(strip_tags($_POST['vaccins']));

    // echo strtotime($dateVAC);

    if (strtotime("now") < strtotime($dateVAC)) {
      $dede = 'no';
    }else {
      $dede = 'yes';
    }

    if (validateDate($dateVAC,'Y-m-d')) {
      foreach ($vaccins as $vaccin) {
        if ($vaccinVAC == $vaccin['id']) {
          $idVac = $vaccin['id'];
        }
      }
      if (!empty($idVac)) {
        $sql = "INSERT INTO v3_users_vaccins (id_user, id_vaccins, created_at, date, fait) VALUES (:iduser, :idvaccins, NOW(), :date, :tr)";
            $query = $pdo->prepare($sql);
            $query->bindValue(':iduser',$iduser);
            $query->bindValue(':idvaccins',$idVac);
            $query->bindValue(':date',$dateVAC);
            $query->bindValue(':tr',$dede);
            $query->execute();

        header('Location: MesVaccins.php');

      }else{
        $errors['vaccins'] = 'veuillez rentrer un vaccin valide';
      }
    }else {
      $errors['date'] = 'veuillez rentrer une date valide';
    }


  }


  // affichée les vaccins A FAIRE dans l'ordre du plus proche collunm Date

  ?>
  <form class="" method="post">
    <p>entré la date</p>
    <input type="date" name="date" value=""><?php afficheErrors($errors,'date'); ?>
    <p>vaccins</p>
    <select name="vaccins"><?php afficheErrors($errors,'vaccins'); ?>

      <?php


      foreach ($vaccins as $key) {

        if(!in_array($key['id'],$vaccinUser)){
<<<<<<< HEAD
          ?><option value="<?= $key['id'] ?>"><?= $key['nom']; ?></option><?php
=======
          ?><option value="<?= $key['id'] ?>"><?php echo $key['nom']; ?></option><?php
>>>>>>> 02afefdbf64822ef035e37f08af9d7d3314ac91d
        }
      }

      ?>


    </select>
    <input type="submit" name="submitted" value="Ajouter">
  </form>
  <table class="" style="text-align: center;">
      <tr>
          <th style="text-align: center;">Nom du vaccin</th>
          <th style="text-align: center;">Le contenue</th>
          <th style="text-align: center;">Statuts</th>
          <th style="text-align: center;">Date</th>
      </tr>
      <?php
          //boucle pour integrer nos données pour remplir notre liste
          foreach ($verifVacId as $vvi) {
            if ($vvi['statuts'] == 1) { //Condition pour transformer les chiffres en BDD en variables sur la liste des vaccins
              $vvist = 'Obligatoire';
          }else {
              $vvist = 'Recommander';
          }

            if (!empty($vvi['fait']) && $vvi['fait'] == 'no') {
              ?><tr>
<<<<<<< HEAD
                  <td><?= $vvi['nom'] ?></td>
                  <td><?= $vvi['content'] ?></td>
                  <td><?= $vvi['statuts'] ?></td>
                  <td>A faire le : <?= $vvi['date'] ?></td>
=======
                <td><?= $vvi['nom'] ?></td>
                <td><?= nl2br($vvi['content']) ?></td>
                <td><?= $vvist ?></td>
                <td>A faire le : <?= $vvi['date'] ?></td>
>>>>>>> 02afefdbf64822ef035e37f08af9d7d3314ac91d
              </tr> <?php
            }
          }

          foreach ($verifVacId as $vvi) {
            if (!empty($vvi['fait']) && $vvi['fait'] == 'yeso') {
              ?><tr>
                  <td><?= $vvi['nom'] ?></td>
                  <td><?= $vvi['content'] ?></td>
                  <td><?= $vvi['statuts'] ?></td>
                  <td>Fais le : <?= $vvi['date'] ?></td>
                  </tr> <?php
            }
          }

          foreach ($verifVacId as $vvi) {
            if (!empty($vvi['fait']) && $vvi['fait'] == 'yes') {
              ?><tr>
<<<<<<< HEAD
                  <td><?= $vvi['nom'] ?></td>
                  <td><?= $vvi['content'] ?></td>
                  <td><?= $vvi['statuts'] ?></td>
                  <td>Fais le : <?= $vvi['date'] ?></td>
=======
                <td><?= $vvi['nom'] ?></td>
                <td><?= nl2br($vvi['content']) ?></td>
                <td><?= $vvist ?></td>
                <td>Fais le : <?= $vvi['date'] ?></td>
>>>>>>> 02afefdbf64822ef035e37f08af9d7d3314ac91d
              </tr> <?php
            }
          }
          ?>
  </table>

  <?php
}else{
  header('Location: connection.php');
}
include('inc/footer.php');

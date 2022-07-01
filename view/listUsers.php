<?php

use blog\controller\Users;

$listUsers = new Users();
$p = $listUsers->listUsers();

$listUsers->deleteUsersId();
$listUsers->giveRole();
$listsearch = new Users();
$search = $listsearch->searchUser();
?>

<!------------------------------------------------- LISTE USERS   HTML    ---------------------------------- -->
<h2 class="h1list">Liste Utilisateurs</h2>
<!----------------------------------  RECHERCHE ARTICLES --------------------------------->
<div class="container-fluid mt-5 p-5">
    <form class="d-flex" action="" method="POST">
        <input type="search" class="form-control me-2" name="rechercheUser" placeholder="pseudo/roles " />
        <button type="submit" name="submitrechercheUserList" class="btn btn-outline-success" value="submitrechercheUser">
            search
        </button>
    </form>
</div>
<br>
<!---------------------------------------------------------------------  -->
<table class="table table-bordered">
    <thead class=" ">
        <tr>
            <th scope="col">id</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Rôle</th>
            <th scope="col">Mail</th>
        </tr>
    </thead>
    <!----------------------------------  TROUVER SEARCH --------------------------------->
    <?php if (!empty($search)) {
        foreach ($search as $reponse) { ?>
            <tbody>
                <tr>
                    <td><?= $reponse->id ?></td>
                    <td><?= $reponse->pseudo ?></td>
                    <td><?= $reponse->nom ?></td>
                    <td> <?= $reponse->email ?></td>
                    <td>
                        <form method="POST">
                            <button type="submit" name="submitDelet" class="btnlist" value="<?= $reponse->id ?>"><i class="fa-solid fa-person-circle-minus"></i></button>
                            <?php if ($reponse->nom === 'utilisateur') { ?>
                                <input type="hidden" name="idAdmins" value="<?= $reponse->id ?>">
                                <button style="color:pink ;" type="submit" name="submitRole" class="btnlist" value="<?= $reponse->id_Roles ?>"><i class="fa-solid fa-crown"></i>
                                </button>
                                <?php  ?>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            </tbody>
    <?php }
    } ?>
    <!----------------------------------  LIST USER --------------------------------->
    <?php if (!empty($p) && empty($search)) {
        foreach ($p  as $users) { ?>
            <tbody>
                <tr>
                    <td><?= $users->id ?></td>
                    <td><?= $users->pseudo ?></td>
                    <td><?= $users->nom ?></td>
                    <td> <?= $users->email ?></td>
                    <td class="td-list">
                        <form method="POST">
                            <button type="submit" name="submitDelet" class="btnlist" value="<?= $users->id ?>"><i class="fa-solid fa-person-circle-minus"></i></button>
                            <?php if ($users->nom === 'utilisateur') { ?>
                                <input type="hidden" name="idAdmins" value="<?= $users->id ?>">
                                <button type="submit" name="submitRole" class="btnlist2" value="<?= $users->id_Roles ?>"><i class="fa-solid fa-crown"></i>
                                </button>
                                <?php  ?>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            </tbody>
    <?php
        }
    }
    ?>
</table>
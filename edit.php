<?php

require 'PDO.php';
try {

    if(!empty($_POST['update'])) {
        if(isset($_GET['upd'])) {
            $id = $_GET['upd'];
        }
        $time = time() + 3600;
        $created_at = date("Y-m-d H:i:s", $time);
        $task = $_POST['update'];
        $prepare = $pdo->prepare("UPDATE todolist SET task = :task, created_at = :created_at WHERE id = :id");
        $yes = $prepare->execute([
            'task' => $task,
            'created_at' => $created_at,
            'id' => $id
        ]);
        if($yes === true) {
            header("location:index.php?edit=$id");
        }
    }

    //Récupérer les taches de la base de donnée
    if(isset($_GET['upd'])) {
        $id = $_GET['upd'];
        $prepare = $pdo->prepare("SELECT * FROM todolist WHERE id = :id");
        $prepare->execute([
            'id' =>$id
        ]);
        $task = $prepare->fetch();  
    }

} catch (PDOException $e) {
    return $e->getMessage();
}


require 'header.php';
?>
<div class="container">
    <h1 class="todolist-title">Modifier votre tache</h1>
    <br>
    <div class="add">
        <form action="" method="post">
            <input type="text" class="add-input" placeholder="Entrez une nouvelle tache à faire..." name="update" value="<?= $task->task ?>">
            <button class="add-button">Modifier</button>
        </form>
    </div>
</div>
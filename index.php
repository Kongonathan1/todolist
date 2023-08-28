<?php

require 'PDO.php';
$success = null;
try {
    //Récupérer les taches de la base de donnée
    $query = $pdo->query("SELECT * FROM todolist ORDER BY created_at DESC");
    $tasks = $query->fetchAll();

    //Permet d'insérer de nouvelles taches dans la base de donnée.
    if(isset($_POST['task'])) {
        if(!empty($_POST['task'])) {
            $task = (string)($_POST['task']);
            $time = time() + 3600;
            $created_at = date('Y-m-d H:i:s', $time);
            $prepare = $pdo->prepare("INSERT INTO todolist (task, created_at) VALUES (:task, :created_at)");
            $yes = $prepare->execute([
                'task' => $task,
                'created_at' => $created_at
            ]);
            if($yes === true) {
                $id= $pdo->lastInsertId();
                header("location:index.php?new=$id");
            }
        } 
    }
    if(isset($_GET['delete'])) {
        $id = (int)($_GET['delete']);
        $prepare = $pdo->prepare("DELETE FROM todolist WHERE id = :id");
        $prepare->execute([
            'id' => $id
        ]);
        header("location:index.php");
    }

} catch (PDOException $e) {
    return $e->getMessage();
}
if(isset($_GET['edit'])) {
    $success = "Votre tache à bien été modifié :)";
    $id = (int)$_GET['edit'];
}
if(isset($_GET['new'])) {
    $id = (int)$_GET['new'];
}


require 'header.php';
?>
<div class="container">
    <h1 class="todolist-title">Bienvenue sur votre To-do-list</h1>
    <br>
    <?php if($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif ?>
    <div class="add">
        <form action="" method="post">
            <input type="text" class="add-input" placeholder="Entrez une nouvelle tache à faire..." name="task" required>
            <button class="add-button">Ajouter <strong class="bigger">+</strong> </button>
        </form>
    </div>
        <div class="task">
            
            <?php if(!empty($tasks)): ?>
                <?php foreach($tasks as $task): ?>
                    <div class="card <?= $id === $task->id ? 'update' : '' ?>">
                        <div class="bigger-flex">    
                            <div class="flex">
                            <input type="checkbox" name="yes" id="yes">
                                <h5 class="done"><?= $task->task ?></h5>
                            </div>
                            <a href="?delete=<?= $task->id ?>">X</a>
                        </div>
                        <div class="card-footer">
                            <small class="card-date">Créer le <?= $task->created_at ?></small>
                            <a href="edit.php?upd=<?= $task->id ?>"><img src="img/edit_todolist_blue.png" alt=""></a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="card-animation">
                    <img src="img/Mario.jpg" alt="" class="img" >
                    <img src="img/gif.gif" alt=""  >
                </div>
            <?php endif ?>
        </div>
</div>


    
<?php require 'footer.php' ?>
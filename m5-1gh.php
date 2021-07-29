<!DOCTYPE html>
<html lang="ja">
    <?php
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザー名';
        $db_pass = 'パスワード';
        $pdo = new PDO($dsn, $user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //編集
        if(isset($_POST["edit"],$_POST["edit_pass"])&&$_POST["edit"]!=""&&$_POST["edit_pass"]!=""){
            $sql = 'SELECT * FROM ttest2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["id"]==$_POST["edit"]&&$row["password"]==$_POST["edit_pass"]){
                    $edit_name=$row["name"];
                    $edit_comment=$row["comment"];
                    $edit_line=$row["id"];
                }
            }    
        }
        
    ?>
    <form action="" method="post">
        <input type="text" name="yourname" placeholder="名前" value="<?php if(isset($edit_name)){echo $edit_name;}?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($edit_comment)){echo $edit_comment;}?>"><br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="hidden" name="editline" value="<?php if(isset($edit_line)){echo $edit_line;}?>">
        <input type ="submit"><br><br>
        <input type="text" name="delete" placeholder="削除したい行"><br>
        <input type="text" name="delete_pass" placeholder="パスワード">
        <input type="submit" value="削除"><br><br>
        <input type="text" name="edit" placeholder="編集したい行"><br>
        <input type="text" name="edit_pass" placeholder="パスワード">
        <input type="submit" value="編集">
    </form>
    <?php
        $dsn = 'mysql:dbname=ʼデータベース名ʼ;host=localhost';
        $user = 'ユーザー名';
        $db_pass = 'パスワード';
        $pdo = new PDO($dsn, $user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql1 = "CREATE TABLE IF NOT EXISTS ttest2"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "date TEXT,"
        . "password TEXT"
        .");";
        $stmt = $pdo->query($sql1);
        $sql2 ='SHOW TABLES';
        $result = $pdo -> query($sql2);
        foreach ($result as $row){
            echo $row[0];
            echo '<br>';
        }
         echo "<hr>";
        //新規投稿
        if(isset($_POST["yourname"],$_POST["comment"],$_POST["password"])&&$_POST["yourname"]!=""&&$_POST["comment"]!=""&&$_POST["password"]!=""&&$_POST["editline"]==""){
            $sql3 = $pdo -> prepare("INSERT INTO ttest2 (name,comment,date,password) VALUES (:name,:comment,:date,:password)");
            $sql3 -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql3 -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql3 -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql3 -> bindParam(':password', $password, PDO::PARAM_STR);
            $name = $_POST["yourname"];
            $comment = $_POST["comment"];
            $date = date("Y年m月d日 H:i:s");
            $password = $_POST["password"];
            $sql3 -> execute();
        }
        //編集
        if(isset($_POST["yourname"],$_POST["comment"],$_POST["password"])&&$_POST["yourname"]!=""&&$_POST["comment"]!=""&&$_POST["password"]!=""&&$_POST["editline"]!=""){
            $id=$_POST["editline"];
            $name=$_POST["yourname"];
            $comment=$_POST["comment"];
            $date=date("Y年m月d日 H:i:s");
            $password=$_POST["password"];
            $sql = 'UPDATE ttest2 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        //削除
        if(isset($_POST["delete"],$_POST["delete_pass"])&&$_POST["delete"]!=""&&$_POST["delete_pass"]!=""){
            $sql = 'SELECT * FROM ttest2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["id"]==$_POST["delete"]&&$row["password"]==$_POST["delete_pass"]){
                    $id=$_POST["delete"];
                    $sql = 'delete from ttest2 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }    
        }
        //ブラウザに表示
        $sql = 'SELECT * FROM ttest2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].','.$row['name'].','.$row['comment'].','.$row['date'].'<br>';
            echo "<hr>";
        }
         
    ?>
</html>
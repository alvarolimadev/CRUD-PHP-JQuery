<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Usuários</title>
</head>
<body>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/MiniProject/index.html">Voltar</a></li>
        </ol>
      </nav>
        <table class="table table-striped">
        <thead class="table table-striped">
        <tr>
        <th scope="col">#</th> 
        <th scope="col">Nome</th>
        <th scope="col">Login</th>
        <th scope="col">Senha</th>
        <th scope="col">CPF</th>
        <th scope="col">Salário</th>
        <th scope="col">Cargo</th>
        <th scope="col">Bonificação</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        
    <?php

        include '/opt/lampp/htdocs/MiniProject/assets/database/conexao.php';

        $sql = "SELECT * FROM projeto.funcionario ORDER BY id ASC" or die($pdo->error);
        $result = $pdo->query($sql);
        $rows = $result->fetchall(PDO::FETCH_ASSOC);

        foreach($rows as $row) {
        echo "<form action='' method='POST'>";
        echo "<tr class='table-light'>";
        echo("<td>".$row["id"]."</td>");
        echo("<td>".$row["nome"]."</td>");
        echo("<td>".$row["login"]."</td>");
        echo("<td>".$row["senha"]."</td>");
        echo("<td>".$row["cpf"]."</td>");
        echo("<td>".$row["salario"]."</td>");
        echo("<td>".$row["cargo"]."</td>");
        echo("<td>".$row["bonificacao"]."</td>");
        echo '<td><button class="btn btn-primary"><a href="lista.php?id_funcionario='.$row['id'].'" class="text-light">Bonificar</a></button></td>';
        echo '<td><button class="btn btn-primary"><a href="/MiniProject/lista/update/alterar_salario.php?id_funcionario_update='.$row['id'].'" class="text-light">Alterar salário</a></button></td>';
        echo '<td><button class="btn btn-danger"><a href="lista.php?id_funcionario_delete='.$row['id'].'" class="text-light">Deletar</a></button></td>';
        
        echo "</tr>";
        } 
    ?>

    <?php

        include '/opt/lampp/htdocs/MiniProject/assets/database/conexao.php';
        
        // Consultar por ID
        if(isset($_GET["id_funcionario"])){

          $id = $_GET["id_funcionario"];

          $sql = "SELECT salario, cargo FROM projeto.funcionario WHERE id = :id" or die($pdo->error);
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':id', $id);
          $result = $stmt->execute();
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Bonificar funcionario
          if($rows[0]['cargo'] == "analista"){

            $sql_update = "UPDATE projeto.funcionario SET bonificacao = salario * 0.5 WHERE id = :id" or die($pdo->error);
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':id', $id);
            $result_update = $stmt_update->execute();
            header('Location: lista.php');
          }
          if($rows[0]['cargo'] == "designer"){

            $sql_update = "UPDATE projeto.funcionario SET bonificacao = salario * 0.3 WHERE id = :id" or die($pdo->error);
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':id', $id);
            $result_update = $stmt_update->execute();
            header('Location: lista.php');
          }
          if($rows[0]['cargo'] == "diretor"){

            $sql_update = "UPDATE projeto.funcionario SET bonificacao = salario * 0.7 WHERE id = :id" or die($pdo->error);
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':id', $id);
            $result_update = $stmt_update->execute();
            header('Location: lista.php');
          }
        }
    ?>

    <?php

    include '/opt/lampp/htdocs/MiniProject/assets/database/conexao.php';

    // Deletar por ID
    if(isset($_GET["id_funcionario_delete"])){

      $id_deletar = $_GET["id_funcionario_delete"];

      $sql_deletar = "DELETE FROM projeto.funcionario WHERE id = :id" or die($pdo->error);
      $stmt_deletar = $pdo->prepare($sql_deletar);
      $stmt_deletar->bindParam(':id', $id_deletar);
      $result_deletar = $stmt_deletar->execute();
      header('Location: lista.php');
    }
    ?>
        </tbody>
       </table>
</body>
</html>
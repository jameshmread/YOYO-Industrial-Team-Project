<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <ul>
        <?php foreach ($users as &$user)  {?>
           <li> <a href='users/<?= $user->id; ?>'><?= $user->name; ?></a></li>
            <?php } ?>
        </ul>
</body>
</html>
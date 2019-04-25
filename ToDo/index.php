<?php
  require_once 'app/init.php';

  $itemsQuery = $db->prepare("
  SELECT id, name, done
  FROM items
  WHERE user = :user");
  $itemsQuery->execute([
    'user' => $_SESSION['user_id']
  ]);

  $items = $itemsQuery->rowCount() ? $itemsQuery : [];

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>To Do</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?Shadow+Into+Light+Two" rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="list">
      <h1 class="header">To Do</h1>
      <?php if(!empty($items)): ?>
      <ul class='items'>
        <?php foreach ($items as $item): ?>
        <li>
          <span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['name']; ?></span>
            <?php if (!$item['done']): ?>
          <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a
            <?php else: ?>
          <a href="mark.php?as=undone&item=<?php echo $item['id']; ?>" class="done-button">Not Done</a
          <?php endif; ?>
        </li>
      <?php endforeach ?>
      </ul>
    <?php else: ?>
      <p>Nothing to DO</p>
    <?php endif; ?>
      <form class="item-add" action="add.php" method="post">
        <input type="text" name="name" placeholder="Write task here" class="input" autocomplete="off" required>
        <input type="submit" class="submit" value="Add">
      </form>
    </div>
  </body>
</html>

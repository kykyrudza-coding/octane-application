<?php extract(['title' => 'Octane']);
include 'layout/top.php'; ?>

<h1>User List</h1>

<?php foreach ($users as $user) { ?>
    <p>User: <?= htmlspecialchars($user->name) ?></p>
<?php } ?>

<div class="pagination">
    <?php if ($current_page > 1) { ?>
        <a href="?page=<?= $current_page - 1 ?>">Previous</a>
    <?php } ?>

    <span>Page <?= $current_page ?> of <?= $total_pages ?></span>

    <?php if ($current_page < $total_pages) { ?>
        <a href="?page=<?= $current_page + 1 ?>">Next</a>
    <?php } ?>
</div>

<?php include 'layout/bottom.php'; ?>

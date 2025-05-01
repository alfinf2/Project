<?php if (isset($_SESSION['flash'])) : ?>
    <div class="ui <?= $_SESSION['flash']['type'] ?> message">
        <div class="header">
            <?= $_SESSION['flash']['title'] ?>
        </div>
        <p>
            <?= $_SESSION['flash']['message'] ?>
        </p>
    </div>
    <?php
        unset($_SESSION['flash']);
    endif;
?>
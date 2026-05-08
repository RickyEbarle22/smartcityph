<?php $pager->setSurroundCount(2); ?>
<nav aria-label="Pagination">
  <ul class="pagination">
    <?php if ($pager->hasPreviousPage()) : ?>
      <li><a href="<?= $pager->getPreviousPage() ?>" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></a></li>
    <?php endif ?>
    <?php foreach ($pager->links() as $link) : ?>
      <li class="<?= $link['active'] ? 'active' : '' ?>">
        <?php if ($link['active']) : ?>
          <span><?= esc($link['title']) ?></span>
        <?php else : ?>
          <a href="<?= esc($link['uri']) ?>"><?= esc($link['title']) ?></a>
        <?php endif ?>
      </li>
    <?php endforeach ?>
    <?php if ($pager->hasNextPage()) : ?>
      <li><a href="<?= $pager->getNextPage() ?>" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></a></li>
    <?php endif ?>
  </ul>
</nav>

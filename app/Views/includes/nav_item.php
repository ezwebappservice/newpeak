<?php
/**
 * Recursive mega-menu item renderer.
 *
 * @param array<string, mixed> $item
 * @param int $depth
 */
function render_nav_item(array $item, int $depth = 0): void
{
    $hasChildren = ! empty($item['children']);

    if ($hasChildren) {
        $visibleChildren = [];
        foreach ($item['children'] as $child) {
            ob_start();
            render_nav_item($child, $depth + 1);
            $html = ob_get_clean();
            if ($html !== '') {
                $visibleChildren[] = $html;
            }
        }
        if (empty($visibleChildren)) {
            return;
        }

        $href = nav_menu_item_href($item);
        $slug = $item['slug'] ?? null;
        $active = theme_nav_is_active($slug);
        $flipClass = ($depth >= 2) ? ' submenu-flip' : '';
        $navClass = ($depth === 0) ? ' nav-item' : '';
        $linkClass = ($depth === 0) ? 'nav-link menu-parent' : 'menu-parent';
        $label = $item['label'] ?? '';
        ?>
        <li class="menu-item menu-item-has-children<?= $flipClass ?><?= $navClass ?>">
          <div class="menu-parent-wrap d-lg-contents">
            <a class="<?= $linkClass ?><?= $active ?>" href="<?= cms_attr($href) ?>"><?= cms_text($label) ?><?php if ($depth === 0): ?><i class="bi bi-chevron-down submenu-caret submenu-caret-desktop d-none d-lg-inline" aria-hidden="true"></i><?php endif; ?></a>
            <button type="button" class="submenu-toggle d-lg-none" aria-label="Toggle <?= cms_attr($label) ?> submenu" aria-expanded="false">
              <i class="bi bi-chevron-down submenu-caret" aria-hidden="true"></i>
            </button>
          </div>
          <ul class="sub-menu">
            <?php foreach ($visibleChildren as $childHtml): ?>
              <?= $childHtml ?>
            <?php endforeach; ?>
          </ul>
        </li>
        <?php
        return;
    }

    $linkType = $item['link_type'] ?? 'page';
    $slug = $item['slug'] ?? null;

    if ($linkType === 'page' && $slug && ! nav_menu_slug_is_linkable($slug)) {
        return;
    }

    $label = $item['label'] ?? '';
    $href = nav_menu_item_href($item);
    $active = theme_nav_is_active($slug);

    if ($depth === 0) {
        ?>
        <li class="menu-item nav-item">
          <a class="nav-link<?= $active ?>" href="<?= cms_attr($href) ?>"><?= cms_text($label) ?></a>
        </li>
        <?php
        return;
    }

    ?>
    <li class="menu-item">
      <a href="<?= cms_attr($href) ?>" class="<?= trim($active) ?>"><?= cms_text($label) ?></a>
    </li>
    <?php
}

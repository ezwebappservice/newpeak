<?php
/**
 * @var list<array<string, mixed>> $categories
 * @var int|string|null $selected
 * @var string $fieldName
 * @var bool $required
 */
$fieldName = $fieldName ?? 'category_id';
$required = $required ?? true;
$selected = (string) ($selected ?? '');
$groups = investor_category_groups($categories);
?>
<select name="<?php echo esc($fieldName); ?>" class="form-control" <?php echo $required ? 'required' : ''; ?>>
    <option value="">Select Category</option>
    <?php foreach ($groups['parents'] as $parent): ?>
        <?php $parentId = (int) $parent['id']; ?>
        <?php if (! empty($groups['children'][$parentId])): ?>
            <optgroup label="<?php echo esc($parent['category_name']); ?>">
                <?php foreach ($groups['children'][$parentId] as $child): ?>
                    <option value="<?php echo (int) $child['id']; ?>" <?php echo $selected === (string) $child['id'] ? 'selected' : ''; ?>>
                        <?php echo esc($child['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>
        <?php else: ?>
            <option value="<?php echo $parentId; ?>" <?php echo $selected === (string) $parentId ? 'selected' : ''; ?>>
                <?php echo esc($parent['category_name']); ?>
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>

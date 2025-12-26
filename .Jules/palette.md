# Palette's Journal

## 2024-05-22 - Explicit Label Association
**Learning:** Legacy PHP forms often omit explicit `for`/`id` association, relying on visual proximity which fails for screen readers.
**Action:** Always check `views/` for bare `<label>` tags and add `for` attributes matching new `id`s on inputs.

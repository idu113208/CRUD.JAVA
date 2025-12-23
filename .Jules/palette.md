# Palette's Journal - Critical Learnings

## 2024-05-22 - Accessibility in Auth Forms
**Learning:** Explicitly associating labels with inputs using `for`/`id` attributes is crucial for accessibility and was missing in some parts of the legacy code. Adding `autocomplete` attributes significantly helps users with password managers.
**Action:** Always verify `for` and `id` match on labels and inputs. Always add `autocomplete` to authentication fields.

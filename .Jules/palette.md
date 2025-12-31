## 2024-05-23 - Authentication Accessibility Improvements
**Learning:** Legacy PHP forms often lack explicit label associations (`for`/`id`) and `autocomplete` attributes, which are critical for accessibility and password manager usability.
**Action:** When touching any form, always audit for and add `for`/`id` pairs and standard `autocomplete` attributes. Adding semantic headers (e.g., `h1` inside cards) and navigation links between related forms (Login <-> Register) provides a significant UX boost with minimal code.
